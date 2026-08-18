#!/usr/bin/env bash
set -u

ROOT="${1:-.}"
cd "$ROOT" || exit 2

RC_VERSION="2.9.1-RC1"
FAIL=0

hr() { printf '\n%s\n' "============================================================"; }
title() { hr; printf '%s\n' "$1"; hr; }
blocker() { printf 'BLOCKER: %s\n' "$1"; FAIL=1; }
ok() { printf 'OK: %s\n' "$1"; }

# Common exclusions for source-tree scans.
GREP_EXCLUDES=(
  --exclude-dir=.git
  --exclude-dir=vendor
  --exclude-dir=writable
  --exclude-dir=node_modules
  --exclude='*.zip'
  --exclude='*.log'
)

title "myCrudCI4 2.9.1-RC1 release audit"
printf 'Root: %s\n' "$(pwd)"
printf 'Expected version: %s\n' "$RC_VERSION"

title "1. Git state"
if command -v git >/dev/null 2>&1 && git rev-parse --is-inside-work-tree >/dev/null 2>&1; then
  git status --short
  if [ -n "$(git status --porcelain)" ]; then
    printf '\nNOTE: working tree is not clean. Review before tagging stable.\n'
  else
    ok "working tree clean"
  fi
else
  printf 'SKIP: not a Git working tree.\n'
fi

title "2. Central version / development labels"
VERSION_HITS="$(grep -RInE "${GREP_EXCLUDES[@]}" \
  '2\.9\.1-(dev|alpha|beta)|dev[0-9]+|fix[0-9]+' app public tests spark composer.json README* docs 2>/dev/null || true)"

if [ -n "$VERSION_HITS" ]; then
  printf '%s\n' "$VERSION_HITS"
  blocker "development/fix labels remain in active source or documentation"
else
  ok "no active dev/fix labels found"
fi

printf '\nOccurrences of expected RC version:\n'
grep -RInF "${GREP_EXCLUDES[@]}" "$RC_VERSION" app public tests spark composer.json README* docs 2>/dev/null || true

title "3. Temporary markers"
TEMP_HITS="$(grep -RInE "${GREP_EXCLUDES[@]}" \
  '\b(TODO|FIXME|XXX|HACK|TEMP|TEMPORARY|WORKAROUND)\b' \
  app public tests spark composer.json README* docs 2>/dev/null || true)"
if [ -n "$TEMP_HITS" ]; then
  printf '%s\n' "$TEMP_HITS"
  blocker "temporary markers found"
else
  ok "no TODO/FIXME/XXX/HACK/TEMP markers found"
fi

title "4. Debug leftovers"
DEBUG_HITS="$(grep -RInE "${GREP_EXCLUDES[@]}" \
  '(^|[^A-Za-z0-9_])(dd|dump|var_dump|print_r)\s*\(|console\.log\s*\(' \
  app public tests spark 2>/dev/null || true)"
if [ -n "$DEBUG_HITS" ]; then
  printf '%s\n' "$DEBUG_HITS"
  blocker "debug calls found"
else
  ok "no common debug calls found"
fi

title "5. PHP syntax"
PHP_FILES="$(find app tests -type f -name '*.php' \
  -not -path '*/Generated/*' \
  -not -path '*/writable/*' 2>/dev/null)"
PHP_BAD=0
while IFS= read -r file; do
  [ -z "$file" ] && continue
  if ! php -l "$file" >/dev/null; then
    php -l "$file" || true
    PHP_BAD=1
  fi
done <<< "$PHP_FILES"

if [ "$PHP_BAD" -eq 1 ]; then
  blocker "PHP lint failures"
else
  ok "PHP source lint passed"
fi

title "6. Composer metadata"
if [ -f composer.json ]; then
  if command -v composer >/dev/null 2>&1; then
    composer validate --no-check-publish || blocker "composer.json validation failed"
  else
    printf 'SKIP: composer command not available.\n'
  fi

  printf '\nPotential development stability flags:\n'
  grep -nE '"minimum-stability"\s*:\s*"dev"|"prefer-stable"\s*:\s*false' composer.json || true
else
  printf 'SKIP: composer.json not found.\n'
fi

title "7. Packaging-risk files"
find . -type f \
  \( -name '.env' -o -name '*.bak' -o -name '*.tmp' -o -name '*.orig' -o -name '*.rej' \
     -o -name '*~' -o -name '*.patch' -o -name '*.diff' -o -name '*.sql' \) \
  -not -path './.git/*' \
  -not -path './vendor/*' \
  -not -path './writable/*' \
  -print 2>/dev/null || true

printf '\nLarge files (>5 MB) outside vendor/writable/.git:\n'
find . -type f -size +5M \
  -not -path './.git/*' \
  -not -path './vendor/*' \
  -not -path './writable/*' \
  -printf '%s %p\n' 2>/dev/null | sort -nr || true

title "8. Documentation consistency"
printf 'Old architecture/version terminology that needs human review:\n'
grep -RInE "${GREP_EXCLUDES[@]}" \
  'myCrudGpt|2\.7\.|2\.8\.|2\.9\.0|dev[0-9]+|fix[0-9]+' \
  README* docs app/Commands app/Libraries 2>/dev/null || true

printf '\nItalian text in developer-facing docs/source (review, not automatic blocker):\n'
grep -RInEi "${GREP_EXCLUDES[@]}" \
  '\b(configurazione|generato|generata|relazione|relazioni|tabella|campo|campi|salva|annulla|crea|modifica|elimina|errore)\b' \
  README* docs app/Commands app/Libraries 2>/dev/null | head -n 200 || true

title "9. Generated/config metadata check"
printf 'Config/version metadata references:\n'
grep -RInE "${GREP_EXCLUDES[@]}" \
  '(generatorVersion|generatedVersion|version).*(2\.9\.1|dev|fix)' \
  app/MyCrudConfig app 2>/dev/null | head -n 200 || true

title "10. Recommended regression commands"
cat <<'CMDS'
php spark mycrud:doctor
php spark mycrud:generate-all --force
php spark mycrud:publish-all --force

php spark mycrud:test-all film
php spark mycrud:test-all customer
php spark mycrud:test-all country
php spark mycrud:test-all category

php spark mycrud:check-api film
php spark mycrud:check-query-layer film
php spark mycrud:mcp-doctor film
CMDS

title "Audit result"
if [ "$FAIL" -eq 0 ]; then
  printf 'PASS: no automatic RC blockers found.\n'
  printf 'Next gate: run the regression commands above and perform a clean-install/package test.\n'
  exit 0
else
  printf 'FAIL: one or more RC blockers require review.\n'
  exit 1
fi
