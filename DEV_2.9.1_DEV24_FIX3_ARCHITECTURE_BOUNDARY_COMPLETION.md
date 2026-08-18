# myCrudCI4 2.9.1-dev24-fix3 — Architecture Boundary Completion

This fix completes the cleanup started in dev24-fix1/fix2.

## Generated Controller

Standard/Full now expose dependencies explicitly:

- `$model` for every read/query operation;
- `$service` only for write/application use-cases.

The legacy `$gateway` name is no longer emitted.

## Generated Model

The generator keeps cross-resource reads static:

- belongsTo options/search/context -> owning parent Model;
- hasMany rows -> owning child Model;
- M2M target options -> target Model;
- pivot reads/writes remain in the current Model because the current resource owns the association.

Create/update method signatures remain feature-aware: unrelated relation parameters are not emitted.

## SQL VIEWs

Read-only SQL VIEWs no longer receive an empty Service class. Their Controller reads directly from the generated Model.

## Goal

No new runtime abstraction is introduced. The generated architecture remains explicit and static:

`Controller READ -> Model`

`Controller WRITE -> Service -> Model`

`Service cross-resource WRITE -> RelatedService -> RelatedModel`
