# myCrudGpt 2.8.0-dev34 - Operational Many-to-Many

Completa lo scaffolding pivot puro introdotto in dev34 con gestione operativa Create/Edit.

## Create/Edit
- Il Builder espone `Seleziona nel Create` e `Sincronizza nell'Edit` per ogni pivot pura.
- Il form genera una selezione multipla N:N dopo i campi diretti.
- Il Create inserisce record principale e pivot nella stessa transazione.
- L'Edit precarica gli ID associati e sincronizza la pivot per diff nella stessa transazione.
- `_many_present[...]` permette di rimuovere tutte le associazioni in Edit.

## Sicurezza server-side
- le chiavi relazione sono whitelist generate dallo schema;
- ogni ID target viene verificato sulla tabella collegata;
- attach/detach modificano esclusivamente la pivot;
- massimo 500 ID per singola relazione nel form scaffold standard;
- pivot arricchite escluse dall'automazione.

## UI
La UI standard è volutamente semplice: `<select multiple>` fino a 500 opzioni. Per tabelle target più grandi il Model/Controller generati restano punti di estensione per sostituire il controllo con ricerca AJAX senza cambiare la logica pivot server-side.

## Fix1 - generazione Controller N:N

Corretto il blocco `manyToManyDataFromPost()` emesso da `ControllerGenerator`: le variabili PHP destinate al Controller generato devono essere escape-ate nella heredoc del generatore. Il difetto causava `Undefined variable $isUpdate` durante la generazione e impediva la scrittura di tutti i CRUD.

## fix2 — rilevamento pivot da FK complete

Corretto `RelationResolver::resolveManyToMany()`. `DbSchema::relationsFor($table)` espone soltanto le FK che coinvolgono direttamente la tabella corrente; quindi, per `film`, veniva vista `film_actor.film_id -> film` ma non `film_actor.actor_id -> actor`. Il resolver ora usa le `foreignKeys` complete della tabella ponte (`getTableInfo($pivot)`) e può costruire correttamente `relationsConfig.manyToMany` per pivot pure come `film_actor` e `film_category`.


### Label N:N composte
Le opzioni delle relazioni N:N usano una label composta quando il target espone campi descrittivi complementari (es. `actor.first_name + actor.last_name`). L'ID resta il valore tecnico inviato e validato server-side.
