# myCrudCI4 MCP Foundation

This directory contains generated MCP foundation manifests.

dev11 generates **read-only CRUD tools** (`list_*`, `get_*`) when enabled.

Principles:

- MCP never queries the database directly.
- Future MCP tools call the generated Service layer.
- STDIO is the initial transport.
- MCP starts read-only.
- `mcp/sdk` is optional until MCP runtime is enabled.
- The manifest targets MCP protocol `2026-07-28`.
- Write tools are still disabled.
- Relation-aware tools are introduced in dev12.

Published manifests live under:

`app/Mcp/Manifests/`