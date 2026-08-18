# myCrudCI4 2.9.1-dev22-fix1 — Static Relational Wiring

This fix removes runtime/dynamic relational dispatch introduced by the Service reuse work.

Generated code now uses relationships known at generation time to emit explicit PHP class references.

Examples:

```php
$data['address_id'] = (new AddressService())->createRelated($related['address_id']);
```

```php
return (new LanguageModel())->relationOptionRows(...);
```

```php
return (new InventoryModel())->childrenByForeignKey(...);
```

No Service registry, dynamic class name, `class_exists()`, or `method_exists()` dispatch is generated for these relationships.

The architecture remains:

- Controller: HTTP orchestration only.
- Service: writes and cross-resource write orchestration.
- Model: queries and persistence for the table it owns.
- Relations known from the DB/config are compiled into static PHP code.
