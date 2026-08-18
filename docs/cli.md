# CLI

myCrudCI4 includes developer-oriented CLI commands.

## Generate one CRUD

```bash
php spark mycrud:generate film
```

By default, the command combines the current database schema with the persistent Builder configuration when available.

Options:

```bash
--architecture=basic|standard|full
--from-schema
--save-config
--force
```

Examples:

```bash
php spark mycrud:generate film --force
php spark mycrud:generate film --architecture=full
php spark mycrud:generate film --from-schema
```

## Publish staging to the application

Preview:

```bash
php spark mycrud:publish film --dry-run
```

Publish without overwriting different operational files:

```bash
php spark mycrud:publish film
```

Explicit overwrite:

```bash
php spark mycrud:publish film --force
```

`app/Generated/` remains intact after publishing.

## Diff

```bash
php spark mycrud:diff film
php spark mycrud:diff film --details
php spark mycrud:diff film --target=generated
```

## Regenerate

```bash
php spark mycrud:regenerate film
php spark mycrud:regenerate film --force
```

## Generate all configured tables

```bash
php spark mycrud:generate-all
php spark mycrud:generate-all --force
```

## Diagnostics

```bash
php spark mycrud:doctor
php spark mycrud:doctor film
php spark mycrud:benchmark film
php spark mycrud:explain film
```

## Regression / generated-code checks

```bash
php spark mycrud:test film
php spark mycrud:test-all film
php spark mycrud:check-api film
php spark mycrud:check-query-layer film
```

## AI project context

```bash
php spark mycrud:ai-context
php spark mycrud:ai-context film
```

Run `php spark list` in your CodeIgniter project to inspect all registered commands and their descriptions.
