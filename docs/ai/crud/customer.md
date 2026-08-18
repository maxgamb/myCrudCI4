# CRUD: customer

- Architecture: **Full**
- Database status: **present**
- Primary key(s): `customer_id`
- DB object type: **BASE TABLE**
- Access mode: **read/write**
- Read-only reason: ``

## Components

- **controller:** `app/Controllers/CustomerController.php`
- **model:** `app/Models/CustomerModel.php`
- **validation:** `app/Validation/CustomerRules.php`
- **views:** `app/Views/customer/`
- **routes:** `app/Routes/customer.php`
- **languageIt:** `app/Language/it/Customer.php`
- **languageEn:** `app/Language/en/Customer.php`
- **service:** `app/Services/CustomerService.php`
- **serviceExtension:** `app/Services/Extensions/CustomerServiceExtension.php`
- **entity:** `app/Entities/CustomerEntity.php`
- **apiController:** `app/Controllers/Api/V1/CustomerApiController.php`
- **apiBaseController:** `app/Controllers/Api/BaseApiController.php`
- **apiResource:** `app/API/Resources/CustomerResource.php`
- **apiValidation:** `app/Validation/CustomerApiRules.php`

## View structure

- Main views use Bootstrap breadcrumb navigation.
- The page-level `h1` contains the table name: `customer`.
- A muted small label identifies the current context (List / New record / Edit record / Record details / Trash).
- Internal form/detail card titles use `h2`, not another `h1`.

## Database fields

| Field | Type | PK | Nullable | Input | Search | Sort | FK |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `customer_id` | `smallint unsigned` | yes | no | `hidden` | yes | yes | `` |
| `store_id` | `tinyint unsigned` |  | no | `select` | yes | yes | `store.store_id` |
| `first_name` | `varchar(45)` |  | no | `text` |  |  | `` |
| `last_name` | `varchar(45)` |  | no | `text` | yes | yes | `` |
| `email` | `varchar(50)` |  | yes | `email` |  |  | `` |
| `address_id` | `smallint unsigned` |  | no | `select` | yes | yes | `address.address_id` |
| `active` | `tinyint(1)` |  | no | `checkbox` |  |  | `` |
| `create_date` | `datetime` |  | no | `hidden` |  |  | `` |
| `last_update` | `timestamp` |  | yes | `datetime-local` |  |  | `` |

## BelongsTo / foreign keys

- `store_id` -> `store.store_id` (display: `store_id`) — **Relational Create enabled**: select existing from the FK input-group or create parent in a Bootstrap Offcanvas using a dedicated parent-field partial (not the full parent create page); generated parent PK is assigned server-side as FK in the same transaction.
- `address_id` -> `address.address_id` (display: `{{address}} {{district}} {{postal_code}}`) — **Relational Create enabled**: select existing from the FK input-group or create parent in a Bootstrap Offcanvas using a dedicated parent-field partial (not the full parent create page); generated parent PK is assigned server-side as FK in the same transaction.

## HasMany

- `payment` via `customer_id`
- `rental` via `customer_id`

## Enabled features

`entity`, `service`, `api`, `ajaxList`, `csvExport`, `wordExport`, `relations`, `timestamps`, `exportButtons`, `createAllowed`, `writable`, `recordDetail`, `recordActions`

## Safe customization

- Generated staging policy: Do not patch app/Generated/ as a customization strategy; regenerate from configuration instead.
- Query owner: `CustomerModel`.
- Relation rule: When the related resource is known at generation-time, call the concrete Model/Service explicitly. Never introduce runtime class/table resolvers.
- Persistent Service extension: `app/Services/Extensions/CustomerServiceExtension.php`.
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
- Keep database access in CustomerModel.
- Keep HTTP coordination in CustomerController.
- Preserve the generated view hierarchy: Bootstrap breadcrumb, one page-level h1 with the table name, then a small page-context label.
- Keep inner form/detail card titles at h2 so generated pages contain only one h1.
- For Relational Create, use a Bootstrap input-group for the standard FK select/actions and a Bootstrap Offcanvas with a dedicated parent-field partial that overlays the current view without changing its layout; never embed the full parent create page and never trust a parent foreign key supplied by the browser: use the primary key generated server-side inside the transaction.
- Put generated business orchestration in CustomerService. Put developer custom Service logic in app/Services/Extensions/CustomerServiceExtension.php; that file is created directly outside app/Generated/, is create-only, and must never be overwritten.
- Available Service extension hooks are beforeCreate/afterCreate, beforeUpdate/afterUpdate and beforeDelete/afterDelete. Keep SQL/query composition in the Model.
- The generated ServiceExtension contains a disabled/commented customization example named exampleApplyBusinessRule(). Uncomment, rename/adapt and call it explicitly from a hook only when needed; example helpers must not execute automatically.
- For cross-resource writes, call the concrete generated Service explicitly (for example new CustomerService()->createRelated(...)); never introduce dynamic service/model/table resolvers.
- Web and REST API must share business logic through CustomerService.
- Use the generated Resource for the external JSON representation.
