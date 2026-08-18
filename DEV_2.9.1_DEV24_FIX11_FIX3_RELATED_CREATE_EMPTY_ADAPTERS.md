# myCrudCI4 2.9.1-dev24-fix11-fix3 — Related Create Empty Adapters

Bugfix for Related Create UI adapters after BaseCrudModel consolidation.

## Fix

- `relatedCreateRelationOptions()` is generated whenever belongsTo Related Create is enabled, even if the inline-created target has no nested selectable foreign keys.
- `manyToManyRelatedCreateRelationOptions()` is generated whenever M:N Related Create is enabled, even if the inline-created target has no nested selectable foreign keys.
- In both cases the adapter safely returns an empty array when there are no nested options.
- No Model/Service ownership or BaseCrudModel behavior changes.

This prevents Controller calls from falling through CodeIgniter Model::__call() and raising BadMethodCallException.
