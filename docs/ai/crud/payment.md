# CRUD: payment

- Architecture: **Full**
- Database status: **present**
- Primary key(s): `payment_id`
- DB object type: **BASE TABLE**
- Access mode: **read/write**
- Read-only reason: ``

## Components

- **controller:** `app/Controllers/PaymentController.php`
- **model:** `app/Models/PaymentModel.php`
- **validation:** `app/Validation/PaymentRules.php`
- **views:** `app/Views/payment/`
- **routes:** `app/Routes/payment.php`
- **languageIt:** `app/Language/it/Payment.php`
- **languageEn:** `app/Language/en/Payment.php`
- **service:** `app/Services/PaymentService.php`
- **serviceExtension:** `app/Services/Extensions/PaymentServiceExtension.php`
- **entity:** `app/Entities/PaymentEntity.php`
- **apiController:** `app/Controllers/Api/V1/PaymentApiController.php`
- **apiBaseController:** `app/Controllers/Api/BaseApiController.php`
- **apiResource:** `app/API/Resources/PaymentResource.php`
- **apiValidation:** `app/Validation/PaymentApiRules.php`

## View structure

- Main views use Bootstrap breadcrumb navigation.
- The page-level `h1` contains the table name: `payment`.
- A muted small label identifies the current context (List / New record / Edit record / Record details / Trash).
- Internal form/detail card titles use `h2`, not another `h1`.

## Database fields

| Field | Type | PK | Nullable | Input | Search | Sort | FK |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `payment_id` | `smallint unsigned` | yes | no | `number` | yes | yes | `` |
| `customer_id` | `smallint unsigned` |  | no | `select` | yes | yes | `customer.customer_id` |
| `staff_id` | `tinyint unsigned` |  | no | `select` | yes | yes | `staff.staff_id` |
| `rental_id` | `int` |  | yes | `select` | yes | yes | `rental.rental_id` |
| `amount` | `decimal(5,2)` |  | no | `number` |  |  | `` |
| `payment_date` | `datetime` |  | no | `hidden` |  |  | `` |
| `last_update` | `timestamp` |  | yes | `datetime-local` |  |  | `` |

## BelongsTo / foreign keys

- `customer_id` -> `customer.customer_id` (display: `last_name`) — **Relational Create enabled**: select existing from the FK input-group or create parent in a Bootstrap Offcanvas using a dedicated parent-field partial (not the full parent create page); generated parent PK is assigned server-side as FK in the same transaction.
- `staff_id` -> `staff.staff_id` (display: `last_name`) — **Relational Create enabled**: select existing from the FK input-group or create parent in a Bootstrap Offcanvas using a dedicated parent-field partial (not the full parent create page); generated parent PK is assigned server-side as FK in the same transaction.
- `rental_id` -> `rental.rental_id` (display: `rental_id`) — **Relational Create enabled**: select existing from the FK input-group or create parent in a Bootstrap Offcanvas using a dedicated parent-field partial (not the full parent create page); generated parent PK is assigned server-side as FK in the same transaction.

## Enabled features

`entity`, `service`, `api`, `ajaxList`, `csvExport`, `wordExport`, `relations`, `timestamps`, `exportButtons`, `createAllowed`, `writable`, `recordDetail`, `recordActions`

## Safe customization

- Generated staging policy: Do not patch app/Generated/ as a customization strategy; regenerate from configuration instead.
- Query owner: `PaymentModel`.
- Relation rule: When the related resource is known at generation-time, call the concrete Model/Service explicitly. Never introduce runtime class/table resolvers.
- Persistent Service extension: `app/Services/Extensions/PaymentServiceExtension.php`.
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
- Keep database access in PaymentModel.
- Keep HTTP coordination in PaymentController.
- Preserve the generated view hierarchy: Bootstrap breadcrumb, one page-level h1 with the table name, then a small page-context label.
- Keep inner form/detail card titles at h2 so generated pages contain only one h1.
- For Relational Create, use a Bootstrap input-group for the standard FK select/actions and a Bootstrap Offcanvas with a dedicated parent-field partial that overlays the current view without changing its layout; never embed the full parent create page and never trust a parent foreign key supplied by the browser: use the primary key generated server-side inside the transaction.
- Put generated business orchestration in PaymentService. Put developer custom Service logic in app/Services/Extensions/PaymentServiceExtension.php; that file is created directly outside app/Generated/, is create-only, and must never be overwritten.
- Available Service extension hooks are beforeCreate/afterCreate, beforeUpdate/afterUpdate and beforeDelete/afterDelete. Keep SQL/query composition in the Model.
- The generated ServiceExtension contains a disabled/commented customization example named exampleApplyBusinessRule(). Uncomment, rename/adapt and call it explicitly from a hook only when needed; example helpers must not execute automatically.
- For cross-resource writes, call the concrete generated Service explicitly (for example new CustomerService()->createRelated(...)); never introduce dynamic service/model/table resolvers.
- Web and REST API must share business logic through PaymentService.
- Use the generated Resource for the external JSON representation.
