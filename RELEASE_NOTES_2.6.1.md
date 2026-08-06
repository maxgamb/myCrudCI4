# myCrudGpt 2.6.1 — Query Layer Consolidation

Release di consolidamento della 2.6, senza nuove funzionalità applicative.

## Correzioni

- i campi `searchable` e `sortable` rispettano ora le impostazioni `ui` del Builder;
- i campi sensibili, binari e di grandi dimensioni restano esclusi dalle ricerche anche in presenza di configurazioni incomplete;
- i JOIN `belongsTo` usano alias univoci basati sulla foreign key;
- supportate più foreign key verso la stessa tabella padre, ad esempio `created_by` e `updated_by` verso `users`;
- la modalità Basic imposta esplicitamente `datatable = false` anche nel comando Spark;
- aggiunto il comando di verifica end-to-end del Query Layer.

## Comando di verifica

```bash
php spark mycrud:check-query-layer nome_tabella
```

Il comando genera e controlla Basic, Standard e Full verificando:

- nessuna query DB nei Controller;
- nessuna query DB nei Service;
- `paginateWithParents()` e assenza DataTables in Basic;
- DataTables server-side in Standard e Full;
- presenza di `baseBuilder()`, `getDetail()` e `datatable()` nel Model;
- rotte coerenti con l'architettura;
- lint PHP dei file generati;
- assenza di placeholder non risolti.

## Strategia confermata

- **Basic:** Controller → Model, Pager nativo CI4;
- **Standard:** Controller → Service → Model, DataTables server-side;
- **Full:** Controller/API → Service → Model, DataTables server-side.
