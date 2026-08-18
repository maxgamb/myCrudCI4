# MCP

myCrudCI4 2.9 provides local read-only MCP support for Full CRUDs.

## Scope

The stable MCP boundary is:

```text
Transport: STDIO
Exposure: local process
Mode: read-only
Database access from tools: forbidden
Application layer: generated Model for read operations
REST/Shield authentication inherited: no
```

## Generated components

A configured table can publish:

```text
app/Mcp/Resources/<Entity>McpResource.php
app/Mcp/Tools/<Entity>Tools.php
app/Mcp/Tools/<Entity>RelationTools.php
app/Mcp/Manifests/<table>.json
```

Typical tools:

```text
list_film
get_film
get_film_language_id
list_film_inventory_by_film_id
```

## Field visibility

MCP has its own field visibility flag (`mcpVisible`). It is intentionally
independent from REST API visibility (`apiVisible`).

## PHPDoc convention

Generated methods separate MCP registration metadata from developer documentation.

```php
/**
 * Returns a paginated read-only list of film records.
 *
 * @param int         $page        Requested page, minimum 1.
 * @param int         $perPage     Records per page, minimum 1 and maximum 100.
 * @param string|null $filterField Filterable MCP field.
 * @param string|null $filterValue Filter value.
 * @param string|null $sort        Sortable MCP field.
 * @param string      $direction   Sort direction: asc or desc.
 *
 * @return array{
 *     data: array<int,array<string,mixed>>,
 *     meta: array<string,mixed>,
 *     links: array<string,mixed>
 * }
 */
#[McpTool(
    name: 'list_film',
    title: 'List film'
)]
```

Rule:

```text
#[McpTool]
→ discovery / name / title

PHPDoc
→ purpose / parameters / return shape / developer documentation
```

No proprietary `@McpTool` PHPDoc annotation is used.

## Local diagnostics

```bash
php spark mycrud:mcp-doctor film
```

## Local STDIO server

```bash
php spark mycrud:mcp-serve film --no-header
```

The process waits for an MCP client on STDIN/STDOUT. `--no-header` is important
because protocol output must not be mixed with application banners.

## Security

MCP tools are read-only in the 2.9 line. They call generated Models for read operations rather than
opening direct database connections. REST Shield configuration is not implicitly
applied to local STDIO MCP.


## Publish lifecycle

MCP runtime artifacts are generator-owned outputs. `mycrud:publish` and
`mycrud:publish-all` therefore keep them synchronized with `app/Generated/` even
in SAFE mode. This includes manifests, CRUD tools, relation tools, and MCP
resources.

When a capability is disabled, stale table-owned MCP artifacts that are no longer
part of the current generation are removed during publish. This prevents an old
`get_*` or relation tool from remaining discoverable after the Builder/configuration
has disabled that capability. Use `--dry-run` to preview both overwrites and removals.
