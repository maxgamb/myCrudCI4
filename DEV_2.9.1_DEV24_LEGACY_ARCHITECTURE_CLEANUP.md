# myCrudCI4 2.9.1-dev24 — Legacy Architecture Cleanup

## Goal

Reduce generated code after the relational Service/Model refactor. The generator now emits one clear path for reads and one for writes instead of keeping wrappers from the older architecture.

## Generated responsibility rule

```text
READ
Controller / API / MCP -> Model

WRITE
Controller / API -> Service -> Model

CROSS-RESOURCE WRITE
Service -> RelatedService -> RelatedModel

DATABASE / SQL / TRANSACTIONS
Model
```

## Service responsibilities

Generated Services contain application write use-cases only: create, createRelated, update, delete, restore/force-delete when enabled, validation and normalization, Extension Points, explicit related-Service calls, and write transaction orchestration delegated to Model primitives.

The following legacy one-line read wrappers are no longer generated: `listPage`, `exportRows`, `countExportRows`, `exportFields`, `apiList`, `relationOptions`, `relatedCreateRelationOptions`, `searchRelationOptions`, `relationOptionById`, `loadHasMany`, M2M option/selection readers, and `deletedList`.

## Model responsibilities

The generated Model is the read/query owner. It exposes list/detail/export/API reads, FK option lookup, hasMany/M2M reads, and its own persistence/query primitives. Parent and child reads keep the static Model-to-Model wiring introduced in dev19/dev22.

## Related Create normalization

`prepareRelatedData()` was an older compatibility path. dev24 folds its behavior into `prepareData()`: empty defaulted values are omitted so the DB default applies; empty nullable values become `null`; nullable FK, date/time, password and DB-managed normalization continue in the same single method.

## Generated code comments

Controllers explicitly document the split: Model for reads, Service for writes. Services document that they own write use-cases only. MCP tools document that they are read-only and use Models directly.

## Compatibility

Basic remains Model-only. Standard and Full keep Services for writes. No new runtime layer, registry, resolver or dynamic class lookup is introduced.
