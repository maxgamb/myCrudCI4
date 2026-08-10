# myCrudGpt 2.8.0-dev27 — Database-managed timestamp

Bugfix/consolidamento dei campi `TIMESTAMP`/`DATETIME` gestiti interamente dal database.

## Riconoscimento

Un campo viene marcato `databaseManaged=true` quando lo schema espone:

- `DEFAULT CURRENT_TIMESTAMP` (anche `CURRENT_TIMESTAMP()` o con precisione);
- `ON UPDATE CURRENT_TIMESTAMP` in `EXTRA`.

Vengono inoltre esposti i metadati tecnici `extra`, `defaultGenerated` e `autoOnUpdate`.
Questi dati derivano sempre dallo schema corrente e non vengono persistiti come scelte del Builder.

## Comportamento generato

Per un campo database-managed:

- resta leggibile in Index/View ed eventualmente esportabile secondo le normali policy UI;
- non viene generato alcun input in Create/Edit;
- non viene generata alcuna regola di validazione;
- non entra in `Model::$allowedFields`;
- viene eliminato dal POST dal `CrudInputProcessor` tramite la lista managed;
- il Service lo elimina nuovamente per difesa se viene invocato direttamente;
- non è scrivibile tramite API/OpenAPI.

Non viene generato un hidden con la stringa `CURRENT_TIMESTAMP`: il valore viene lasciato al database.

## Builder

Il campo è mostrato con badge `DB automatico`; il tipo input, gli attributi form e `Visibile form` sono bloccati perché la gestione è tecnica e schema-authoritative.

## Drift e contesto IA

Lo schema fingerprint include `extra`, `defaultGenerated`, `autoOnUpdate` e `databaseManaged`, così una variazione della gestione automatica DB viene rilevata come schema drift. Il contesto IA espone `databaseManaged`, default ed extra.
