# myCrudCI4 2.9.1-dev2-fix11 — M2M Related Create Persistence

Fixes a persistence bug in `CrudConfigRepository`.

Previously the Builder exposed:

```text
Create new related record
```

but `createRelatedEnabled` was omitted when saving
`app/MyCrudConfig/<table>.php`.

Result:

```text
Builder checked
→ save configuration
→ option lost
→ regenerate
→ generated form had no inline related-create panel
```

The repository now persists:

```php
'createRelatedEnabled' => true|false
```

for every many-to-many relation.

After installing this fix, open the Builder, re-enable the option if necessary,
save the configuration again, and regenerate the CRUD.
