# myCrudGpt 2.8.0-dev20 — Sakila consolidation

This snapshot is a consolidation release driven by the real MySQL Sakila test database.

## Safety rules added

- MySQL VIEW objects are detected and generated read-only.
- Composite primary keys are detected completely. In 2.8 they are generated read-only rather than producing unsafe record actions using only the first key column.
- Composite-key exports use all PK columns as a deterministic cursor.
- Spatial fields are not exposed as ordinary text fields in list/form/filter/sort/export/API; detail/hasMany reads use `ST_AsText()`.
- hasMany previews keep all child fields except the technical `deleted_at` field.

## Read-only means

Available: index, server-side filters, pager, CSV/Word export and API list.

Disabled: create, edit, update, delete, record-detail routes and write API endpoints when a row cannot be addressed safely by the current single-segment route model.

Full writable multi-column primary-key routing is intentionally not implemented in this consolidation snapshot.
