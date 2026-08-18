# CRUD: staff

- Architecture: **Full**
- Database status: **present**
- Primary key(s): `staff_id`
- DB object type: **BASE TABLE**
- Access mode: **read/write**
- Read-only reason: ``

## Components

- **controller:** `app/Controllers/StaffController.php`
- **model:** `app/Models/StaffModel.php`
- **validation:** `app/Validation/StaffRules.php`
- **views:** `app/Views/staff/`
- **routes:** `app/Routes/staff.php`
- **languageIt:** `app/Language/it/Staff.php`
- **languageEn:** `app/Language/en/Staff.php`
- **service:** `app/Services/StaffService.php`
- **serviceExtension:** `app/Services/Extensions/StaffServiceExtension.php`
- **entity:** `app/Entities/StaffEntity.php`
- **apiController:** `app/Controllers/Api/V1/StaffApiController.php`
- **apiBaseController:** `app/Controllers/Api/BaseApiController.php`
- **apiResource:** `app/API/Resources/StaffResource.php`
- **apiValidation:** `app/Validation/StaffApiRules.php`

## View structure

- Main views use Bootstrap breadcrumb navigation.
- The page-level `h1` contains the table name: `staff`.
- A muted small label identifies the current context (List / New record / Edit record / Record details / Trash).
- Internal form/detail card titles use `h2`, not another `h1`.

## Database fields

| Field | Type | PK | Nullable | Input | Search | Sort | FK |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `staff_id` | `tinyint unsigned` | yes | no | `number` | yes | yes | `` |
| `first_name` | `varchar(45)` |  | no | `text` |  |  | `` |
| `last_name` | `varchar(45)` |  | no | `text` |  |  | `` |
| `address_id` | `smallint unsigned` |  | no | `select` | yes | yes | `address.address_id` |
| `picture` | `blob` |  | yes | `textarea` |  |  | `` |
| `email` | `varchar(50)` |  | yes | `email` |  |  | `` |
| `store_id` | `tinyint unsigned` |  | no | `select` | yes | yes | `store.store_id` |
| `active` | `tinyint(1)` |  | no | `checkbox` |  |  | `` |
| `username` | `varchar(16)` |  | no | `text` |  |  | `` |
| `password` | `varchar(40)` |  | yes | `text` |  |  | `` |
| `last_update` | `timestamp` |  | no | `datetime-local` |  |  | `` |

## BelongsTo / foreign keys

- `address_id` -> `address.address_id` (display: `address`) — **Relational Create enabled**: select existing from the FK input-group or create parent in a Bootstrap Offcanvas using a dedicated parent-field partial (not the full parent create page); generated parent PK is assigned server-side as FK in the same transaction.
- `store_id` -> `store.store_id` (display: `store_id`) — **Relational Create enabled**: select existing from the FK input-group or create parent in a Bootstrap Offcanvas using a dedicated parent-field partial (not the full parent create page); generated parent PK is assigned server-side as FK in the same transaction.

## HasMany

- `payment` via `staff_id`
- `rental` via `staff_id`
- `store` via `manager_staff_id`

## Enabled features

`entity`, `service`, `api`, `ajaxList`, `csvExport`, `wordExport`, `relations`, `timestamps`, `exportButtons`, `createAllowed`, `writable`, `recordDetail`, `recordActions`

## Safe customization

- Generated staging policy: Do not patch app/Generated/ as a customization strategy; regenerate from configuration instead.
- Query owner: `StaffModel`.
- Relation rule: When the related resource is known at generation-time, call the concrete Model/Service explicitly. Never introduce runtime class/table resolvers.
- Persistent Service extension: `app/Services/Extensions/StaffServiceExtension.php`.
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
- Keep database access in StaffModel.
- Keep HTTP coordination in StaffController.
- Preserve the generated view hierarchy: Bootstrap breadcrumb, one page-level h1 with the table name, then a small page-context label.
- Keep inner form/detail card titles at h2 so generated pages contain only one h1.
- For Relational Create, use a Bootstrap input-group for the standard FK select/actions and a Bootstrap Offcanvas with a dedicated parent-field partial that overlays the current view without changing its layout; never embed the full parent create page and never trust a parent foreign key supplied by the browser: use the primary key generated server-side inside the transaction.
- Put generated business orchestration in StaffService. Put developer custom Service logic in app/Services/Extensions/StaffServiceExtension.php; that file is created directly outside app/Generated/, is create-only, and must never be overwritten.
- Available Service extension hooks are beforeCreate/afterCreate, beforeUpdate/afterUpdate and beforeDelete/afterDelete. Keep SQL/query composition in the Model.
- The generated ServiceExtension contains a disabled/commented customization example named exampleApplyBusinessRule(). Uncomment, rename/adapt and call it explicitly from a hook only when needed; example helpers must not execute automatically.
- For cross-resource writes, call the concrete generated Service explicitly (for example new CustomerService()->createRelated(...)); never introduce dynamic service/model/table resolvers.
- Web and REST API must share business logic through StaffService.
- Use the generated Resource for the external JSON representation.
