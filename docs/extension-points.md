# Service Extension Points

Standard and Full architectures can generate a Service layer.

To keep custom application logic safe across regeneration, myCrudCI4 creates a persistent Service Extension trait outside `app/Generated/`.

Typical location:

```text
app/Services/Extensions/<Service>Extension.php
```

The file is **create-only**. Once it exists, generator force options do not overwrite it.

Available hooks include:

```php
protected function beforeCreate(array $data): array
protected function afterCreate(int|string $id, array $data): void

protected function beforeUpdate(int|string $id, array $data): array
protected function afterUpdate(int|string $id, array $data): void

protected function beforeDelete(int|string $id): void
protected function afterDelete(int|string $id): void
```

## Recommended separation

- HTTP input/output belongs in the Controller/API Controller.
- Application validation, transactions and orchestration belong in the Service.
- Record-local casts, dates, accessors/mutators and behavior belong in the Entity.
- Query composition and persistence belong in the Model.
- Custom business behavior that must survive regeneration belongs in the Service Extension.
- Generated files should remain reproducible from schema + configuration.

`Entity::fromArray()` is intentionally small: it constructs an Entity from a prepared array. It is **not** a validation method. Generated Service validation runs before Entity construction.

For Standard/Full writes the normal order is:

```text
prepareData
→ validation
→ beforeCreate/beforeUpdate
→ Entity::fromArray
→ Model persistence
→ afterCreate/afterUpdate
```

Use Entity methods only for behavior intrinsic to one record. If an operation coordinates multiple Models/resources, changes availability, creates payments, opens a transaction or applies a workflow transition, it belongs in a Service/Service Extension.

This separation allows repeated regeneration without forcing custom business logic into generator templates.
