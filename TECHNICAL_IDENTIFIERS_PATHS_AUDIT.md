# Technical Identifiers & Paths Audit

Version target: `2.9.1-dev2-fix7`

## Canonical paths

- `app/MyCrudConfig/` — persistent per-table configuration
- `app/Generated/` — safe staging
- `app/Services/Extensions/` — persistent developer extension code
- `tests/Generated/MyCrud/` — published generated contract tests
- `writable/uploads/` — runtime uploads
- `app/OpenApi/` — published OpenAPI specifications
- `app/Mcp/` — published MCP resources/tools/manifests

## Identifier audit

- App PSR-4 `use` statements checked: 118
- Missing App classes: 0
- Corrupted identifier tokens found: 0

## Route audit

- `/mycrud` — OK
- `/mycrud/builder` — OK
- `/mycrud/builder/configure/<table>` — OK

## Important distinction

Some published target directories (`app/OpenApi/`, `app/Mcp/`,
`tests/Generated/MyCrud/`) may not exist in a clean package before the relevant
CRUD is generated and published. They are nevertheless the canonical runtime
publish destinations used by myCrudCI4.
