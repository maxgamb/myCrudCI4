# myCrudGpt 2.6 — Query Layer & Pagination Strategy

## Obiettivi

- Nessuna query SQL nei Controller generati.
- Service dedicato alla sola orchestrazione applicativa.
- Query centralizzate nei Model.
- Basic con paginazione nativa CodeIgniter 4.
- Standard e Full con DataTables server-side.

## Model generati

Ogni Model espone:

- `baseBuilder()` con tutti i `LEFT JOIN` verso le tabelle padre;
- `getDetail()` con i dati descrittivi dei parent;
- `paginateWithParents()` per Basic;
- `datatable()` per Standard e Full;
- un metodo opzioni specifico per ogni `belongsTo`;
- un metodo di lettura e conteggio specifico per ogni `hasMany`;
- `relationOptions()` e `loadHasMany()` come facciate del Query Layer.

La ricerca DataTables e la ricerca Basic sono limitate ai campi adatti, escludendo campi grandi, file e dati sensibili.

## Controller generati

- Basic: `Controller → Model`, Pager CI4 e nessun endpoint DataTables.
- Standard/Full: `Controller → Service → Model` e DataTables server-side.
- Nessun `db_connect()`, `table()`, `select()` o `join()` nel Controller.

## Route

La rotta `datatable` viene generata soltanto per Standard e Full.

## Verifiche

- Lint PHP eseguito su tutto il pacchetto.
- Generazione di prova Basic e Standard.
- Lint superato per Controller, Model, Service e Routes generati.
