# myCrudCI4 2.9.1-dev24-fix4 — Architecture Boundary Packaging Fix

This fix addresses two issues found while inspecting generated `Customer` and `Film` artifacts.

1. Standard/Full Controllers declare `$model` for reads and `$service` for writes. The generator now contains an explicit guard against the legacy `$gateway` symbol.
2. The release ZIP is flat at project root. Extracting it over an existing myCrudCI4 project updates `app/`, tests and docs directly instead of creating a nested release directory.

Expected generated boundary:

```text
READ   Controller -> Model
WRITE  Controller -> Service -> Model
CROSS-RESOURCE WRITE Service -> RelatedService -> RelatedModel
```

The ModelGenerator remains feature-aware: non-M2M resources receive simple `createRecord(array $data)` / `updateRecord(...)`; M2M target reads are delegated to target Models while pivot persistence remains owned by the current Model.
