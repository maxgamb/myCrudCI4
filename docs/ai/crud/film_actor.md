# CRUD: film_actor

- Architecture: **Full**
- Database status: **present**
- Primary key(s): `actor_id, film_id`
- DB object type: **BASE TABLE**
- Access mode: **create-only (record actions protected)**
- Read-only reason: `composite_primary_key`

## Components

- **controller:** `app/Controllers/FilmActorController.php`
- **model:** `app/Models/FilmActorModel.php`
- **validation:** `app/Validation/FilmActorRules.php`
- **views:** `app/Views/film_actor/`
- **routes:** `app/Routes/film_actor.php`
- **languageIt:** `app/Language/it/FilmActor.php`
- **languageEn:** `app/Language/en/FilmActor.php`
- **service:** `app/Services/FilmActorService.php`
- **serviceExtension:** `app/Services/Extensions/FilmActorServiceExtension.php`
- **entity:** `app/Entities/FilmActorEntity.php`
- **apiController:** `app/Controllers/Api/V1/FilmActorApiController.php`
- **apiBaseController:** `app/Controllers/Api/BaseApiController.php`
- **apiResource:** `app/API/Resources/FilmActorResource.php`
- **apiValidation:** `app/Validation/FilmActorApiRules.php`

## View structure

- Main views use Bootstrap breadcrumb navigation.
- The page-level `h1` contains the table name: `film_actor`.
- A muted small label identifies the current context (List / New record / Edit record / Record details / Trash).
- Internal form/detail card titles use `h2`, not another `h1`.

## Database fields

| Field | Type | PK | Nullable | Input | Search | Sort | FK |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `actor_id` | `smallint unsigned` | yes | no | `select` | yes | yes | `actor.actor_id` |
| `film_id` | `smallint unsigned` | yes | no | `select` | yes | yes | `film.film_id` |
| `last_update` | `timestamp` |  | no | `datetime-local` |  |  | `` |

## BelongsTo / foreign keys

- `actor_id` -> `actor.actor_id` (display: `last_name`) — **Relational Create enabled**: select existing from the FK input-group or create parent in a Bootstrap Offcanvas using a dedicated parent-field partial (not the full parent create page); generated parent PK is assigned server-side as FK in the same transaction.
- `film_id` -> `film.film_id` (display: `title`) — **Relational Create enabled**: select existing from the FK input-group or create parent in a Bootstrap Offcanvas using a dedicated parent-field partial (not the full parent create page); generated parent PK is assigned server-side as FK in the same transaction.

## Enabled features

`entity`, `service`, `api`, `ajaxList`, `csvExport`, `wordExport`, `relations`, `timestamps`, `exportButtons`, `readOnly`, `createAllowed`

## Safe customization

- Generated staging policy: Do not patch app/Generated/ as a customization strategy; regenerate from configuration instead.
- Query owner: `FilmActorModel`.
- Relation rule: When the related resource is known at generation-time, call the concrete Model/Service explicitly. Never introduce runtime class/table resolvers.
- Persistent Service extension: `app/Services/Extensions/FilmActorServiceExtension.php`.
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
- Keep database access in FilmActorModel.
- Keep HTTP coordination in FilmActorController.
- Preserve the generated view hierarchy: Bootstrap breadcrumb, one page-level h1 with the table name, then a small page-context label.
- Keep inner form/detail card titles at h2 so generated pages contain only one h1.
- For Relational Create, use a Bootstrap input-group for the standard FK select/actions and a Bootstrap Offcanvas with a dedicated parent-field partial that overlays the current view without changing its layout; never embed the full parent create page and never trust a parent foreign key supplied by the browser: use the primary key generated server-side inside the transaction.
- Put generated business orchestration in FilmActorService. Put developer custom Service logic in app/Services/Extensions/FilmActorServiceExtension.php; that file is created directly outside app/Generated/, is create-only, and must never be overwritten.
- Available Service extension hooks are beforeCreate/afterCreate, beforeUpdate/afterUpdate and beforeDelete/afterDelete. Keep SQL/query composition in the Model.
- The generated ServiceExtension contains a disabled/commented customization example named exampleApplyBusinessRule(). Uncomment, rename/adapt and call it explicitly from a hook only when needed; example helpers must not execute automatically.
- For cross-resource writes, call the concrete generated Service explicitly (for example new CustomerService()->createRelated(...)); never introduce dynamic service/model/table resolvers.
- Web and REST API must share business logic through FilmActorService.
- Use the generated Resource for the external JSON representation.
