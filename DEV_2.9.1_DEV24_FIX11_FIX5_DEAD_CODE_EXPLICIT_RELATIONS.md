# myCrudCI4 2.9.1-dev24-fix11-fix5

## Goal

Reduce generated dead code without changing CRUD behavior, while making explicit/static relation methods the preferred generated API.

## Architectural rule

Relation ownership is resolved at generation time. Generated PHP names the related class directly (for example `new ActorModel()` or `new AddressService()`). Generic BaseCrudModel helpers may execute a query only against the current Model's own `$table`; they never select another Model/table dynamically.

## Cleanup

- Empty Related Create option adapters are inherited from `BaseCrudModel`.
- BelongsTo SELECT methods return final option maps directly.
- No generated `RELATION_SEARCHES` runtime map or `toRelationOptions()` dispatcher.
- GIS branches/constants are generated only for spatial tables.
- `prepareData()` is feature-aware and omits unused `$isUpdate`.
- Relation templates support `{field}` and `{{field}}`.

## Regression contract

Generated relational tests reject dynamic constructors and dynamic DB table resolution, while allowing generic own-table helpers inherited from `BaseCrudModel`.
