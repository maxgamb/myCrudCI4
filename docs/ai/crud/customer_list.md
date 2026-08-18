# CRUD: customer_list

- Architecture: **Full**
- Database status: **present**
- Primary key(s): ``
- DB object type: **VIEW**
- Access mode: **read-only**
- Read-only reason: `database_view`

## Components

- **controller:** `app/Controllers/CustomerListController.php`
- **model:** `app/Models/CustomerListModel.php`
- **validation:** `app/Validation/CustomerListRules.php`
- **views:** `app/Views/customer_list/`
- **routes:** `app/Routes/customer_list.php`
- **languageIt:** `app/Language/it/CustomerList.php`
- **languageEn:** `app/Language/en/CustomerList.php`
- **service:** `app/Services/CustomerListService.php`
- **serviceExtension:** `app/Services/Extensions/CustomerListServiceExtension.php`
- **entity:** `app/Entities/CustomerListEntity.php`
- **apiController:** `app/Controllers/Api/V1/CustomerListApiController.php`
- **apiBaseController:** `app/Controllers/Api/BaseApiController.php`
- **apiResource:** `app/API/Resources/CustomerListResource.php`
- **apiValidation:** `app/Validation/CustomerListApiRules.php`

## View structure

- Main views use Bootstrap breadcrumb navigation.
- The page-level `h1` contains the table name: `customer_list`.
- A muted small label identifies the current context (List / New record / Edit record / Record details / Trash).
- Internal form/detail card titles use `h2`, not another `h1`.

## Database fields

| Field | Type | PK | Nullable | Input | Search | Sort | FK |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `ID` | `smallint unsigned` |  | no | `number` |  |  | `` |
| `name` | `varchar(91)` |  | yes | `text` |  |  | `` |
| `address` | `varchar(50)` |  | no | `text` |  |  | `` |
| `zip code` | `varchar(10)` |  | yes | `text` |  |  | `` |
| `phone` | `varchar(20)` |  | no | `text` |  |  | `` |
| `city` | `varchar(50)` |  | no | `text` |  |  | `` |
| `country` | `varchar(50)` |  | no | `text` |  |  | `` |
| `notes` | `varchar(6)` |  | no | `text` |  |  | `` |
| `SID` | `tinyint unsigned` |  | no | `number` |  |  | `` |

## Enabled features

`entity`, `service`, `api`, `ajaxList`, `csvExport`, `wordExport`, `timestamps`, `exportButtons`, `readOnly`

## Safe customization

- Generated staging policy: Do not patch app/Generated/ as a customization strategy; regenerate from configuration instead.
- Query owner: `CustomerListModel`.
- Relation rule: When the related resource is known at generation-time, call the concrete Model/Service explicitly. Never introduce runtime class/table resolvers.
- Persistent Service extension: `app/Services/Extensions/CustomerListServiceExtension.php`.
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
- Keep database access in CustomerListModel.
- Keep HTTP coordination in CustomerListController.
- Preserve the generated view hierarchy: Bootstrap breadcrumb, one page-level h1 with the table name, then a small page-context label.
- Keep inner form/detail card titles at h2 so generated pages contain only one h1.
- For Relational Create, use a Bootstrap input-group for the standard FK select/actions and a Bootstrap Offcanvas with a dedicated parent-field partial that overlays the current view without changing its layout; never embed the full parent create page and never trust a parent foreign key supplied by the browser: use the primary key generated server-side inside the transaction.
- Put generated business orchestration in CustomerListService. Put developer custom Service logic in app/Services/Extensions/CustomerListServiceExtension.php; that file is created directly outside app/Generated/, is create-only, and must never be overwritten.
- Available Service extension hooks are beforeCreate/afterCreate, beforeUpdate/afterUpdate and beforeDelete/afterDelete. Keep SQL/query composition in the Model.
- The generated ServiceExtension contains a disabled/commented customization example named exampleApplyBusinessRule(). Uncomment, rename/adapt and call it explicitly from a hook only when needed; example helpers must not execute automatically.
- For cross-resource writes, call the concrete generated Service explicitly (for example new CustomerService()->createRelated(...)); never introduce dynamic service/model/table resolvers.
- Web and REST API must share business logic through CustomerListService.
- Use the generated Resource for the external JSON representation.
