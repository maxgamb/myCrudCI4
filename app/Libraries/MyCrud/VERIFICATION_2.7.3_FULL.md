# Verifica myCrudGpt 2.7.3 Full

Controlli eseguiti sulla base 2.7.3:

- generazione completa di un CRUD di prova con Entity, Model, Service, Validation, Controller, API v1, Resource, OpenAPI, viste e rotte;
- sintassi PHP valida per tutti i file dell'applicazione e per tutti i file di prova generati;
- OpenAPI YAML di prova valida;
- output confinato in `app/Generated/`;
- rifiuto dei percorsi diretti verso `app/Controllers` e dei percorsi con `..`;
- layout `default_crud` per myCrudGpt e `default_app` per le viste applicative;
- nessun contenuto prima di `<?php` nei file Language;
- import Entity del Model generato verificato;
- rotta CSV dichiarata prima delle rotte dinamiche.
