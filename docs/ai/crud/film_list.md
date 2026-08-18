# CRUD: film_list

- Architecture: **Full**
- Database status: **present**
- Primary key(s): ``
- DB object type: **VIEW**
- Access mode: **read-only**
- Read-only reason: `database_view`

## Components

- **controller:** `app/Controllers/FilmListController.php`
- **model:** `app/Models/FilmListModel.php`
- **validation:** `app/Validation/FilmListRules.php`
- **views:** `app/Views/film_list/`
- **routes:** `app/Routes/film_list.php`
- **languageIt:** `app/Language/it/FilmList.php`
- **languageEn:** `app/Language/en/FilmList.php`
- **service:** `app/Services/FilmListService.php`
- **serviceExtension:** `app/Services/Extensions/FilmListServiceExtension.php`
- **entity:** `app/Entities/FilmListEntity.php`
- **apiController:** `app/Controllers/Api/V1/FilmListApiController.php`
- **apiBaseController:** `app/Controllers/Api/BaseApiController.php`
- **apiResource:** `app/API/Resources/FilmListResource.php`
- **apiValidation:** `app/Validation/FilmListApiRules.php`

## View structure

- Main views use Bootstrap breadcrumb navigation.
- The page-level `h1` contains the table name: `film_list`.
- A muted small label identifies the current context (List / New record / Edit record / Record details / Trash).
- Internal form/detail card titles use `h2`, not another `h1`.

## Database fields

| Field | Type | PK | Nullable | Input | Search | Sort | FK |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `FID` | `smallint unsigned` |  | no | `number` |  |  | `` |
| `title` | `varchar(128)` |  | no | `text` |  |  | `` |
| `description` | `text` |  | yes | `textarea` |  |  | `` |
| `category` | `varchar(25)` |  | yes | `text` |  |  | `` |
| `price` | `decimal(4,2)` |  | no | `number` |  |  | `` |
| `length` | `smallint unsigned` |  | yes | `number` |  |  | `` |
| `rating` | `enum('g','pg','pg-13','r','nc-17')` |  | yes | `text` |  |  | `` |
| `actors` | `text` |  | yes | `textarea` |  |  | `` |

## Enabled features

`entity`, `service`, `api`, `ajaxList`, `csvExport`, `wordExport`, `timestamps`, `exportButtons`, `readOnly`

## Safe customization

- Generated staging policy: Do not patch app/Generated/ as a customization strategy; regenerate from configuration instead.
- Query owner: `FilmListModel`.
- Relation rule: When the related resource is known at generation-time, call the concrete Model/Service explicitly. Never introduce runtime class/table resolvers.
- Persistent Service extension: `app/Services/Extensions/FilmListServiceExtension.php`.
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
- Keep database access in FilmListModel.
- Keep HTTP coordination in FilmListController.
- Preserve the generated view hierarchy: Bootstrap breadcrumb, one page-level h1 with the table name, then a small page-context label.
- Keep inner form/detail card titles at h2 so generated pages contain only one h1.
- For Relational Create, use a Bootstrap input-group for the standard FK select/actions and a Bootstrap Offcanvas with a dedicated parent-field partial that overlays the current view without changing its layout; never embed the full parent create page and never trust a parent foreign key supplied by the browser: use the primary key generated server-side inside the transaction.
- Put generated business orchestration in FilmListService. Put developer custom Service logic in app/Services/Extensions/FilmListServiceExtension.php; that file is created directly outside app/Generated/, is create-only, and must never be overwritten.
- Available Service extension hooks are beforeCreate/afterCreate, beforeUpdate/afterUpdate and beforeDelete/afterDelete. Keep SQL/query composition in the Model.
- The generated ServiceExtension contains a disabled/commented customization example named exampleApplyBusinessRule(). Uncomment, rename/adapt and call it explicitly from a hook only when needed; example helpers must not execute automatically.
- For cross-resource writes, call the concrete generated Service explicitly (for example new CustomerService()->createRelated(...)); never introduce dynamic service/model/table resolvers.
- Web and REST API must share business logic through FilmListService.
- Use the generated Resource for the external JSON representation.
