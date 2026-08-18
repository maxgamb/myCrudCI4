# myCrudCI4 2.9.1-RC1

Release candidate for myCrudCI4 2.9.1.

## Status

Feature set frozen.

No new functionality is planned between RC1 and 2.9.1 stable.
Only release-blocking bug fixes, packaging fixes, documentation corrections,
and regression-test fixes are allowed.

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

## RC1 validation

Validated against the configured project CRUD set:

- Configured CRUDs: 23
- generate-all: OK 23
- generation FAIL: 0
- schema drift: 0
- full CRUD regression: 23/23
- SQL VIEW regression: FAIL 0
- writable CRUD regression: FAIL 0

## RC1 release cleanup

- Central version set to `2.9.1-RC1`.
- Active documentation aligned with RC1.
- AI project context regenerated for RC1.
- Development ZIP archives removed from version control.
- Runtime myCrud reports removed from version control.
- Temporary `.orig`, `.bak`, `.tmp`, and `.rej` artifacts excluded.
- Regression diagnostics updated so read-only SQL VIEW capabilities are tested correctly.

## Before promotion to 2.9.1 stable

RC1 must pass:

1. clean repository/package export;
2. installation in a clean CodeIgniter 4 project/environment;
3. Builder startup;
4. CRUD generation;
5. representative Basic, Standard and Full runtime checks;
6. final regression suite with zero failures;
7. final documentation/version audit.

If these checks pass, promotion to `2.9.1` must not introduce feature changes.
