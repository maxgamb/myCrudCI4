# myCrudCI4 2.9.1-dev24-fix7 — Strict Cleanup & PHPDoc

## Goal

Finish the dev24 architectural cleanup without adding product features. Generated code should contain only branches required by the configured resource and every public/generated operation should explain its responsibility through PHPDoc.

## Architecture

- Controller: HTTP flow only. Reads use the Model; writes use the Service.
- Service: validation, normalization, transaction/use-case orchestration and explicit Service-to-Service writes.
- Model: SQL for its own table and owned pivots, plus explicit named relation methods.

## Cleanup

- Controller upload helpers/imports/properties/constants are emitted only when uploads exist.
- M2M related-create parsing/validation helpers are emitted only when that capability exists.
- Standard/Full createRecord() and updateRecord() persist only the current table.
- M2M synchronization is invoked explicitly by the Service through named Model methods.
- Basic remains self-contained because it intentionally has no Service layer.

## Validation

Service validation uses both generated rules and generated custom messages.

## PHPDoc policy

Generated classes document each operation boundary, parameters, return values, exceptions, transaction ownership and cross-resource calls. Inline comments are reserved for non-obvious orchestration steps; PHPDoc documents methods rather than individual PHP expressions.
