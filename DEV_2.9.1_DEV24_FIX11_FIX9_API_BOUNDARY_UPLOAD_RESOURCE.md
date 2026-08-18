# myCrudCI4 2.9.1-dev24-fix11-fix9

## Scope

This is an API-boundary cleanup over fix8. It does not change Web Related Create/Offcanvas, Model ownership, Service orchestration, or OpenAPI operation capabilities.

## REST architecture

- ApiController owns REST input, writable whitelist, filter whitelist, sort whitelist, validation, and HTTP error mapping.
- Service owns write use-cases and cross-resource orchestration.
- Model owns reads and persistence.
- Resource is output-only serialization: READABLE, make(), collection().
- OpenAPI documents the REST contract and does not expose Web-only `_related*`, `_many*`, or offcanvas concepts.

## Uploads

Fields generated as `file` or `image` never accept a persisted filename through a normal JSON/form body. They are excluded from `WRITABLE_FIELDS`. When API create/update capabilities permit uploads, the generated ApiController uses `CrudUploadManager` and the multipart upload endpoint/path.

## Static relation rule

Relations remain explicit and generated at generation-time. No runtime Model/Service resolver is introduced by this change.
