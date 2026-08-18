# 2.9.1-dev24-fix11-fix10 — REST Patch / Upload / MCP Boundary

This fix closes the API boundary audit without changing the Web Related Create UI or relational ownership model.

## REST write use-cases

Generated Full Services expose explicit write operations:

- `update()` for complete PUT/Web updates;
- `patch()` for REST partial updates, validating only fields present in the payload;
- `updateUploads()` for filenames produced by the validated `CrudUploadManager` multipart pipeline.

The ApiController delegates `PATCH` to `patch()` and multipart upload persistence to `updateUploads()` rather than routing both through full `update()` validation.

## MCP boundary

`*McpResource` is now an output-only serializer (`READABLE`, `make()`, `collection()`). MCP filter/sort policies are generated as static constants in `*Tools`, which owns request/tool argument validation.

## Architecture preserved

- REST/MCP reads use the explicit generated Model.
- REST writes use the explicit generated Service.
- Cross-resource relations continue to use statically generated Model-to-Model and Service-to-Service calls.
- No runtime Model/Service/table resolver is introduced.
- Web Related Create Offcanvas behavior is unchanged.
