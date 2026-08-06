# myCrudGpt 2.7.1 — correzioni

Pacchetto correttivo della versione 2.7 del Generatore CRUD per CodeIgniter 4.

## Correzioni principali

- output dei generatori riportato nelle cartelle standard `app/` coerenti con i namespace `App\\...`;
- rotte MyCrud consolidate e caricamento dei CRUD da `app/Routes/*.php` senza duplicazioni;
- query CRUD, DataTables, REST, relazioni padre e tabelle figlie centralizzate nei Model;
- conteggi DataTables corretti anche con ricerca globale, filtri colonna e soft delete;
- API v1 con Resource sicura, whitelist di campi leggibili/scrivibili/filtrabili/ordinabili e supporto Entity;
- gestione corretta di PUT/PATCH, errori 404/422/500, paginazione e link REST;
- campi sensibili esclusi da output, ricerca, ordinamento e OpenAPI;
- password obbligatoria in creazione ma opzionale in modifica, senza cancellare il valore esistente;
- campi `created_at`, `updated_at` e `deleted_at` protetti da scrittura manuale;
- validazione generata da schema DB, nullable, lunghezze, unique singole e foreign key;
- fix dei tipi booleani `tinyint(1)` per form, Entity e OpenAPI;
- Builder esteso con opzioni searchable, sortable, visibleIndex, visibleForm, visibleView e sensitive;
- CSRF globale per le interfacce web, token aggiornato nelle chiamate DataTables e protezione dal doppio invio;
- Pager Basic corretto con template CI4 `default_full`;
- correzione dell'update Full con Entity e del valore restituito dagli insert con chiavi non intere;
- rimozione dei riferimenti obsoleti alla cartella di staging `app/Generated`.

## Verifiche eseguite

- lint PHP dell'intera cartella `app`;
- generazione di prova nelle architetture Basic, Standard e Full;
- lint di tutti i PHP generati;
- verifica che controller e service generati non contengano query DB;
- validazione sintattica della specifica OpenAPI generata.

## Nota installazione

Effettuare un backup dell'applicazione e unire la cartella `app/` con il progetto CodeIgniter 4. Le API generate sotto `api/v1/*` sono predisposte per uso stateless: applicare il filtro di autenticazione/API key o Bearer token previsto dall'applicazione prima dell'esposizione pubblica.
