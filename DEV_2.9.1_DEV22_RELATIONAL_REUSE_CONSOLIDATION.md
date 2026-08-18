# myCrudCI4 2.9.1-dev22 — Relational Reuse Consolidation

This release consolidates the relational ownership/refactoring introduced in dev19-dev21 without adding a new runtime layer.

## Architectural contracts

- Parent/FK option queries are delegated to the parent Model through `relationOptionRows()`.
- HasMany child reads are delegated to the child Model through `childrenByForeignKey()`.
- Standard/Full Related Create writes use the related generated Service.
- Standard/Full M2M Related Create writes use the related generated Service; pivot synchronization remains owned by the main resource Model.
- Basic keeps its Model-only write path because it has no Service layer.
- Controllers remain HTTP/request/response coordinators and do not receive relational SQL.

## Regression protection

Generated `RelationalContractTest` files now explicitly assert relational read ownership and Service write ownership.
`mycrud:test-all <table>` also checks that generated parent/child reads still point to the owning Models.

No registry, dependency graph, service locator, or additional runtime abstraction was introduced.
