# myCrudCI4 2.9.1-dev24-fix11 — BaseCrudModel Consolidation

This maintenance release consolidates infrastructure shared by generated Models without changing relation ownership.

## Architecture

Generated Models now extend `App\Models\BaseCrudModel`. The base class owns only generic operations that always target the current Model's own table: list-filter execution, cached counts, transaction primitives, reusable owned-table relation reads, and API link composition.

Generated Models continue to contain the explicit domain wiring. For example, `FilmModel` still calls `ActorModel`, `CategoryModel`, `LanguageModel`, and `InventoryModel` directly. `CustomerModel` still calls `AddressModel`, `StoreModel`, `PaymentModel`, and `RentalModel` directly. The generator does not resolve a target Model or table dynamically at runtime.

## Generated Model contract

Each generated Model exposes protected schema whitelists used by the base class:

- `RESOURCE_FIELDS`
- `RESOURCE_FIELD_TYPES`
- `FOREIGN_KEY_FIELDS`
- `LIST_FILTERS`
- `COUNT_CACHE_SECONDS`

Resource-specific `SORTABLE_FIELDS`, `EXPORT_FIELDS`, joins, belongsTo methods, hasMany methods, many-to-many methods, and persistence methods remain in the generated Model.

## Migration note

`RelationalQuerySupport` is superseded by `BaseCrudModel`. A clean installation no longer contains the trait. When overlaying this release on an existing project, the old `app/Libraries/Crud/RelationalQuerySupport.php` file may remain on disk but is no longer referenced and can be removed after verifying generated Models extend `BaseCrudModel`.
