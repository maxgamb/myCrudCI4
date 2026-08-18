# CRUD: film

- Architecture: **Full**
- Database status: **present**
- Primary key(s): `film_id`
- DB object type: **BASE TABLE**
- Access mode: **read/write**
- Read-only reason: ``

## Components

- **controller:** `app/Controllers/FilmController.php`
- **model:** `app/Models/FilmModel.php`
- **validation:** `app/Validation/FilmRules.php`
- **views:** `app/Views/film/`
- **routes:** `app/Routes/film.php`
- **languageIt:** `app/Language/it/Film.php`
- **languageEn:** `app/Language/en/Film.php`
- **service:** `app/Services/FilmService.php`
- **serviceExtension:** `app/Services/Extensions/FilmServiceExtension.php`
- **entity:** `app/Entities/FilmEntity.php`
- **apiController:** `app/Controllers/Api/V1/FilmApiController.php`
- **apiBaseController:** `app/Controllers/Api/BaseApiController.php`
- **apiResource:** `app/API/Resources/FilmResource.php`
- **apiValidation:** `app/Validation/FilmApiRules.php`

## View structure

- Main views use Bootstrap breadcrumb navigation.
- The page-level `h1` contains the table name: `film`.
- A muted small label identifies the current context (List / New record / Edit record / Record details / Trash).
- Internal form/detail card titles use `h2`, not another `h1`.

## Database fields

| Field | Type | PK | Nullable | Input | Search | Sort | FK |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `film_id` | `smallint unsigned` | yes | no | `hidden` | yes | yes | `` |
| `title` | `varchar(128)` |  | no | `text` | yes | yes | `` |
| `description` | `text` |  | yes | `textarea` |  |  | `` |
| `release_year` | `year` |  | yes | `text` |  |  | `` |
| `language_id` | `tinyint unsigned` |  | no | `select` | yes | yes | `language.language_id` |
| `original_language_id` | `tinyint unsigned` |  | yes | `select` | yes | yes | `language.language_id` |
| `rental_duration` | `tinyint unsigned` |  | no | `number` |  |  | `` |
| `rental_rate` | `decimal(4,2)` |  | no | `number` |  |  | `` |
| `length` | `smallint unsigned` |  | yes | `text` |  |  | `` |
| `replacement_cost` | `decimal(5,2)` |  | no | `number` |  |  | `` |
| `rating` | `enum('g','pg','pg-13','r','nc-17')` |  | yes | `text` |  |  | `` |
| `special_features` | `set('trailers','commentaries','deleted scenes','behind the scenes')` |  | yes | `text` |  |  | `` |
| `last_update` | `timestamp` |  | no | `datetime-local` |  |  | `` |
| `uploads` | `varchar(200)` |  | yes | `file` |  |  | `` |

## BelongsTo / foreign keys

- `language_id` -> `language.language_id` (display: `name`) — **Relational Create enabled**: select existing from the FK input-group or create parent in a Bootstrap Offcanvas using a dedicated parent-field partial (not the full parent create page); generated parent PK is assigned server-side as FK in the same transaction.
- `original_language_id` -> `language.language_id` (display: `name`) — **Relational Create enabled**: select existing from the FK input-group or create parent in a Bootstrap Offcanvas using a dedicated parent-field partial (not the full parent create page); generated parent PK is assigned server-side as FK in the same transaction.

## HasMany

- `film_actor` via `film_id`
- `film_category` via `film_id`
- `inventory` via `film_id`

## Enabled features

`entity`, `service`, `api`, `ajaxList`, `csvExport`, `wordExport`, `relations`, `timestamps`, `exportButtons`, `createAllowed`, `writable`, `recordDetail`, `recordActions`

## Safe customization

- Generated staging policy: Do not patch app/Generated/ as a customization strategy; regenerate from configuration instead.
- Query owner: `FilmModel`.
- Relation rule: When the related resource is known at generation-time, call the concrete Model/Service explicitly. Never introduce runtime class/table resolvers.
- Persistent Service extension: `app/Services/Extensions/FilmServiceExtension.php`.
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
- Keep database access in FilmModel.
- Keep HTTP coordination in FilmController.
- Preserve the generated view hierarchy: Bootstrap breadcrumb, one page-level h1 with the table name, then a small page-context label.
- Keep inner form/detail card titles at h2 so generated pages contain only one h1.
- For Relational Create, use a Bootstrap input-group for the standard FK select/actions and a Bootstrap Offcanvas with a dedicated parent-field partial that overlays the current view without changing its layout; never embed the full parent create page and never trust a parent foreign key supplied by the browser: use the primary key generated server-side inside the transaction.
- Put generated business orchestration in FilmService. Put developer custom Service logic in app/Services/Extensions/FilmServiceExtension.php; that file is created directly outside app/Generated/, is create-only, and must never be overwritten.
- Available Service extension hooks are beforeCreate/afterCreate, beforeUpdate/afterUpdate and beforeDelete/afterDelete. Keep SQL/query composition in the Model.
- The generated ServiceExtension contains a disabled/commented customization example named exampleApplyBusinessRule(). Uncomment, rename/adapt and call it explicitly from a hook only when needed; example helpers must not execute automatically.
- For cross-resource writes, call the concrete generated Service explicitly (for example new CustomerService()->createRelated(...)); never introduce dynamic service/model/table resolvers.
- Web and REST API must share business logic through FilmService.
- Use the generated Resource for the external JSON representation.
