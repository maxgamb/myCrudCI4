# myCrudGpt 2.8.0-dev31 — STABLE

Base consolidata della linea 2.8 al 10 agosto 2026.

## Funzioni consolidate
- View structure: breadcrumb, unico H1, sottotitolo contestuale.
- Builder docs e AI Project Context aggiornati.
- FK navigation e FK Create Context.
- Model relation aliases `<foreign_key>__label`.
- Database-managed TIMESTAMP/DATETIME.
- Relational Create parent inline con partial dedicato.
- Bootstrap Offcanvas sovrapposto alla vista principale.
- FK standard con Bootstrap input-group e azioni integrate.
- Parent create link disabilitato quando Relational Create è attivo.
- Insert parent + child nella stessa transazione.

## Fuori scope
- Relational Edit.
- Gestione hasMany editabile.
- Pivot / many-to-many.
- Cascate relazionali multilivello.
