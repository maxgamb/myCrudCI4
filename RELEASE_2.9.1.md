# myCrudCI4 2.9.1

Stable release of myCrudCI4 2.9.1.

## Status

Stable release.

Version `2.9.1` completed the release-candidate validation cycle and is the current stable release.

## Architecture

- Basic: Model-based web CRUD.
- Standard: Entity + Model reads + Service writes.
- Full: Standard architecture + REST API v1 + OpenAPI.
- Generated relations use explicit/static Model and Service dependencies.
- Runtime relation resolvers are not part of the architecture.
- Shared BaseCrudModel infrastructure remains limited to reusable owned-table behavior.
- SQL VIEW resources are read-only and do not generate write Services.
- ServiceExtension is the persistent customization point for Standard/Full writable CRUDs.
- Generated code under app/Generated/ may be regenerated.

## Stable validation

Validated against the configured project CRUD set:

- Configured CRUDs: 23
- generate-all: OK 23
- generation FAIL: 0
- schema drift: 0
- full CRUD regression: 23/23
- SQL VIEW regression: FAIL 0
- writable CRUD regression: FAIL 0

## Release cleanup

- Central version set to `2.9.1`.
- Active documentation aligned with the stable release.
- AI project context regenerated for the stable release.
- Development ZIP archives removed from version control.
- Runtime myCrud reports removed from version control.
- Temporary `.orig`, `.bak`, `.tmp`, and `.rej` artifacts excluded.
- Regression diagnostics updated so read-only SQL VIEW capabilities are tested correctly.
