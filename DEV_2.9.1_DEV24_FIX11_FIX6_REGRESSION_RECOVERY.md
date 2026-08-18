# myCrudCI4 2.9.1-dev24-fix11-fix6 — Regression Recovery

This fix updates regression contracts after the dev24 feature-aware cleanup.

## Preserved architecture

- Controller -> Model for reads.
- Controller -> Service for writes in Standard/Full.
- Model -> explicitly generated related Model for cross-resource reads.
- Service -> explicitly generated related Service for cross-resource writes.
- BaseCrudModel contains only current-table infrastructure and never resolves a related Model dynamically.

## Diagnostic fixes

- Hook-order checks support both feature-aware `prepareData($data)` and update-aware `prepareData($data, bool $isUpdate)`.
- Related Create checks accept inherited transaction methods from BaseCrudModel and require `RELATED_CREATES` metadata only in BASIC, where the Model owns the inline write flow.
- Cascaded navigation accepts `_trail` as the generated hidden form field; legacy `data-trail` remains accepted.

No runtime relation dispatcher or metadata-driven Model/Service resolver is introduced.
