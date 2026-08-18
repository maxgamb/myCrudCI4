# 2.9.1-dev24-fix1 - Feature-Aware Service Cleanup

This fix completes the legacy Service cleanup started in dev24.

## Generation rule

The generator emits only code that is required by the current table schema and Builder configuration. A simple table therefore receives a simple Service.

## Validation ownership

- `XService::create()` -> `XRules::createRules()`
- `XService::createRelated()` -> `XRules::createRules()`
- `XService::update()` -> `XRules::updateRules($id)`

Controllers may still pre-validate for form UX, but the Service remains authoritative for every write entry point.

## Feature-aware signatures

Unused `related`, `manyToMany`, and `manyToManyNew` arguments are no longer emitted. Transaction code is emitted only when inline cross-resource creation is possible.

## Feature-aware normalization

Constants and normalization branches for passwords, automatic dates, DB-managed fields, nullable FKs, datetime fields, nullable fields, and defaulted fields are generated only when applicable.

## Model write naming

A Model without operational many-to-many relations exposes `updateRecord()`. `updateRecordWithManyToMany()` is reserved for Models that actually synchronize many-to-many relations.
