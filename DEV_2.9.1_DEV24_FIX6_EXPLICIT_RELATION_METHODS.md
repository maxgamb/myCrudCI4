# myCrudCI4 2.9.1-dev24-fix6 — Explicit Relation Methods

This fix completes the static relational architecture for generated Models and Services.

## Rules

- Parent/child/many-to-many relations are emitted as named PHP methods.
- Generated Services call related Services through named helpers; no generic `createRelatedViaServices()` or `createManyToManyRelatedViaServices()` dispatcher is emitted.
- Generated Models expose named belongsTo search/find methods and named many-to-many option/selected/sync methods.
- Pivot SQL remains in the Model that owns the association.
- Target-table reads/validation are delegated to the target Model.
- Generic HTTP adapters may dispatch a field name only to already-generated named methods; they never resolve table names or SQL metadata at runtime.

## Intended architecture

`Controller -> Model` for reads.

`Controller -> Service -> Model` for writes.

`Service A -> named helper -> Service B -> Model B` for cross-resource writes.

`Model A -> named relation method -> Model B` for cross-resource reads.
