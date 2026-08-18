# myCrudCI4 2.9.1-dev24-fix11-fix12 — Related Create Contract Relaxation

This is a diagnostic-only regression recovery release.

## Why

The generated STANDARD/FULL architecture already uses explicit static Service-to-Service wiring for inline parent creation, but the regression runner still compared some generated fragments too literally. That could report `create record collegato` as FAIL even when the generated wiring was correct.

## Contract

For every applicable inline parent create, the diagnostic verifies structurally that:

- the current Service has a named helper for the specific relation;
- the helper instantiates the concrete related Service class;
- the concrete Service `createRelated()` method is invoked;
- the returned identifier is assigned to the concrete foreign-key field;
- transaction primitives remain present;
- dynamic service/model resolution remains forbidden.

Applicability now matches `ServiceGenerator`: the Builder relation must be enabled, schema analysis must mark related create as available, and a concrete parent table must exist.

## Non-goals

No generated runtime behavior changes. Offcanvas UI, BaseCrudModel, explicit Model/Service relations, REST PATCH/upload, Resource/OpenAPI boundaries and MCP boundaries are unchanged.
