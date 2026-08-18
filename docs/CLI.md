# CLI Reference

myCrudCI4 currently registers **19 Spark commands** under the `mycrud:` namespace.

This page is the canonical command inventory. Usage strings below mirror the command classes in `app/Commands/`.

## Generation

### `mycrud:generate`

Generates a CRUD from the DB schema and the Builder persistent configuration.

```bash
php spark mycrud:generate <table> [--architecture basic|standard|full] [--from-schema] [--save-config] [--force]
```

### `mycrud:generate-all`

Generates all CRUDs in app/MyCrudConfig/ using their saved architecture.

```bash
php spark mycrud:generate-all [--force]
```

### `mycrud:regenerate`

Rigenera da config persistente dopo aver mostrato il diff rispetto al codice operativo.

```bash
php spark mycrud:regenerate <table> [--force]
```

## Review and publishing

### `mycrud:diff`

Confronta la nuova generazione con app/ o app/Generated/ senza modificare file.

```bash
php spark mycrud:diff <table> [--target app|generated] [--all] [--details]
```

### `mycrud:publish`

Publishes one configured CRUD from app/Generated/ to app/.

```bash
php spark mycrud:publish <table> [--dry-run] [--force]
```

### `mycrud:publish-all`

Publishes all configured CRUDs from app/Generated/ to app/ and tests/.

```bash
php spark mycrud:publish-all [--dry-run] [--force]
```

## Tests

### `mycrud:test`

Generates and verifies a CRUD on a real table.

```bash
php spark mycrud:test <table> [--no-force] [--json] [--report path]
```

### `mycrud:test-all`

Runs Basic/Standard/Full regression tests and the persistent-configuration lifecycle.

```bash
php spark mycrud:test-all <table>
```

### `mycrud:test-generated`

Runs published scaffold tests for a single CRUD.

```bash
php spark mycrud:test-generated <table> [--list] [--stop-on-failure]
```

### `mycrud:test-dashboard`

Tests the generated Dashboard DTO/object boundaries and published runtime.

```bash
php spark mycrud:test-dashboard
```


### `mycrud:release-check`

Runs the release-candidate readiness matrix across one or more real tables. Per-table gates cover CRUD/relations, published generated tests, API/OpenAPI, and the common query layer. Project-wide gates cover Dashboard, Shield contracts, CLI documentation coverage, and architecture/Builder guards.

```bash
php spark mycrud:release-check <table> [table ...]
```

Example release matrix:

```bash
php spark mycrud:release-check film customer staff store rental
```

The command does not publish application files. Some gates regenerate replaceable staging output under `app/Generated/`. A non-zero exit code means the project is not RC-ready.

## Diagnostics

### `mycrud:doctor`

Checks the project or table schema/indexes/performance.

```bash
php spark mycrud:doctor [table] [--explain] [--benchmark] [--json] [--report path]
```

### `mycrud:benchmark`

Measures COUNT, first page, deep page, and indexed filter.

```bash
php spark mycrud:benchmark <table> [--iterations 5] [--per-page 50]
```

### `mycrud:explain`

Runs EXPLAIN on representative CRUD list queries.

```bash
php spark mycrud:explain <table> [--per-page 50]
```

### `mycrud:check-api`

Generates and checks API controller, Resource, Routes, and OpenAPI.

```bash
php spark mycrud:check-api <table>
```

### `mycrud:check-query-layer`

Generates the Full CRUD and checks Bootstrap AJAX, CSV, Word, Query Layer, and lint.

```bash
php spark mycrud:check-query-layer <table>
```

### `mycrud:ai-context`

Generates AI_PROJECT_CONTEXT.md and the project/CRUD AI map.

```bash
php spark mycrud:ai-context [table]
```

## MCP

### `mycrud:mcp-doctor`

Checks MCP configuration, manifest, and the official PHP SDK.

```bash
php spark mycrud:mcp-doctor [table]
```

### `mycrud:mcp-serve`

Run il server MCP STDIO read-only di un CRUD pubblicato.

```bash
php spark mycrud:mcp-serve <table> --no-header
```

The MCP server uses STDIO. Keep protocol STDOUT free from banners or debug output.
`--no-header` is required for `mycrud:mcp-serve` to avoid corrupting JSON-RPC STDOUT.
