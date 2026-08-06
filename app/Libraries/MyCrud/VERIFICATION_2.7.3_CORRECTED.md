# Verifica myCrudGpt 2.7.3 corretta

Verifiche eseguite sulla generazione sintetica Basic, Standard e Full:

- sintassi PHP dei sorgenti;
- sintassi PHP di tutti i file generati;
- differenze progressive tra Basic, Standard e Full;
- output esclusivo in `app/Generated/`;
- doppia paginazione e tabella `.table-sm`;
- filtri in `<details>` e caricamento AJAX con fallback GET;
- CSV e Word HTML a blocchi;
- hashing delle password nel Controller Basic e nel Service Standard/Full;
- esclusione dei campi sensibili da lista, dettaglio, export, Resource e OpenAPI;
- file lingua separati per CRUD;
- caricamento hasMany senza query COUNT aggiuntiva;
- cache del conteggio non filtrato;
- assenza di CSS personalizzato nelle viste generate.
