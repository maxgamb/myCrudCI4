# myCrudCI4 2.9.1-dev24-fix11-fix1 — Related Create UI Restore

Focused regression fix after the BaseCrudModel consolidation.

## Restored behavior

Safe Related Create actions are scaffolded by Quick/generate-all for:

- belongsTo foreign keys when the parent target is compatible;
- pure many-to-many targets when related-create is compatible.

The generated Create form again exposes the `New` action without requiring a second
manual Builder pass for legacy configurations whose stored `false` value was only an
old generator default.

## Explicit Builder decisions remain authoritative

Two customization markers are now persisted:

- `relationCreateCustomized` for belongsTo fields;
- `createRelatedCustomized` for many-to-many relations.

Once the developer saves the Builder, an explicit disabled choice remains disabled on
future regenerate/generate-all runs. Older snapshots without these markers are migrated
so obsolete default `false` values do not hide available Related Create functionality.

## Architecture

No BaseCrudModel, Model ownership, Service orchestration, transaction, or query-layer
behavior is changed by this fix.
