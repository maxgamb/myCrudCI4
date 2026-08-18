# CRUD: address

- Architecture: **Full**
- Database status: **present**
- Primary key(s): `address_id`
- DB object type: **BASE TABLE**
- Access mode: **read/write**
- Read-only reason: ``

## Components

- **controller:** `app/Controllers/AddressController.php`
- **model:** `app/Models/AddressModel.php`
- **validation:** `app/Validation/AddressRules.php`
- **views:** `app/Views/address/`
- **routes:** `app/Routes/address.php`
- **languageIt:** `app/Language/it/Address.php`
- **languageEn:** `app/Language/en/Address.php`
- **service:** `app/Services/AddressService.php`
- **serviceExtension:** `app/Services/Extensions/AddressServiceExtension.php`
- **entity:** `app/Entities/AddressEntity.php`
- **apiController:** `app/Controllers/Api/V1/AddressApiController.php`
- **apiBaseController:** `app/Controllers/Api/BaseApiController.php`
- **apiResource:** `app/API/Resources/AddressResource.php`
- **apiValidation:** `app/Validation/AddressApiRules.php`

## View structure

- Main views use Bootstrap breadcrumb navigation.
- The page-level `h1` contains the table name: `address`.
- A muted small label identifies the current context (List / New record / Edit record / Record details / Trash).
- Internal form/detail card titles use `h2`, not another `h1`.

## Database fields

| Field | Type | PK | Nullable | Input | Search | Sort | FK |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `address_id` | `smallint unsigned` | yes | no | `number` | yes | yes | `` |
| `address` | `varchar(50)` |  | no | `text` |  |  | `` |
| `address2` | `varchar(50)` |  | yes | `text` |  |  | `` |
| `district` | `varchar(20)` |  | no | `text` |  |  | `` |
| `city_id` | `smallint unsigned` |  | no | `select` | yes | yes | `city.city_id` |
| `postal_code` | `varchar(10)` |  | yes | `text` |  |  | `` |
| `phone` | `varchar(20)` |  | no | `text` |  |  | `` |
| `location` | `geometry` |  | no | `text` |  |  | `` |
| `last_update` | `timestamp` |  | no | `datetime-local` |  |  | `` |

## BelongsTo / foreign keys

- `city_id` -> `city.city_id` (display: `city`) — **Relational Create enabled**: select existing from the FK input-group or create parent in a Bootstrap Offcanvas using a dedicated parent-field partial (not the full parent create page); generated parent PK is assigned server-side as FK in the same transaction.

## HasMany

- `customer` via `address_id`
- `staff` via `address_id`
- `store` via `address_id`

## Enabled features

`entity`, `service`, `api`, `ajaxList`, `csvExport`, `wordExport`, `relations`, `timestamps`, `exportButtons`, `createAllowed`, `writable`, `recordDetail`, `recordActions`

## Safe customization

- Generated staging policy: Do not patch app/Generated/ as a customization strategy; regenerate from configuration instead.
- Query owner: `AddressModel`.
- Relation rule: When the related resource is known at generation-time, call the concrete Model/Service explicitly. Never introduce runtime class/table resolvers.
- Persistent Service extension: `app/Services/Extensions/AddressServiceExtension.php`.
- Hook contract: `prepareData -> beforeCreate/beforeUpdate -> Model persistence -> afterCreate/afterUpdate`.
- Example helper: `exampleApplyBusinessRule(array $data): array` — It is generated commented/disabled. Uncomment, rename/adapt it to real fields, then call it explicitly from beforeCreate/beforeUpdate only when needed.

```php
protected function beforeCreate(array $data): array
{
    return $this->exampleApplyBusinessRule($data);
}
```

## Development guidance

- Preserve exact database field names in PHP arrays and objects.
- Do not singularize class names derived from table names.
- Keep database access in AddressModel.
- Keep HTTP coordination in AddressController.
- Preserve the generated view hierarchy: Bootstrap breadcrumb, one page-level h1 with the table name, then a small page-context label.
- Keep inner form/detail card titles at h2 so generated pages contain only one h1.
- For Relational Create, use a Bootstrap input-group for the standard FK select/actions and a Bootstrap Offcanvas with a dedicated parent-field partial that overlays the current view without changing its layout; never embed the full parent create page and never trust a parent foreign key supplied by the browser: use the primary key generated server-side inside the transaction.
- Put generated business orchestration in AddressService. Put developer custom Service logic in app/Services/Extensions/AddressServiceExtension.php; that file is created directly outside app/Generated/, is create-only, and must never be overwritten.
- Available Service extension hooks are beforeCreate/afterCreate, beforeUpdate/afterUpdate and beforeDelete/afterDelete. Keep SQL/query composition in the Model.
- The generated ServiceExtension contains a disabled/commented customization example named exampleApplyBusinessRule(). Uncomment, rename/adapt and call it explicitly from a hook only when needed; example helpers must not execute automatically.
- For cross-resource writes, call the concrete generated Service explicitly (for example new CustomerService()->createRelated(...)); never introduce dynamic service/model/table resolvers.
- Web and REST API must share business logic through AddressService.
- Use the generated Resource for the external JSON representation.
