# myCrudGpt 2.8.0-dev34 — Pivot / Many-to-Many Scaffolding

Base: dev33 fix2.

## Obiettivo
Generare un'impalcatura leggibile per relazioni N:N senza trasformare myCrudGpt in un editor relazionale automatico.

## Riconoscimento pivot pure
Una tabella viene proposta come pivot automatica solo quando:
- ha esattamente due FK;
- collega la tabella corrente a una seconda tabella;
- gli eventuali campi extra sono timestamp tecnici gestiti dal DB.

Una pivot con campi applicativi (prezzo, quantità, ruolo, note...) non viene assorbita: resta un normale hasMany/CRUD perché è un'entità applicativa.

## Generazione
Per ogni N:N abilitata:
- preview semantica dei record target nella View del padre, senza mostrare la tabella pivot tecnica;
- partial dedicato `_many_<relazione>.php`;
- Model methods `get...ViaPivot()`, `attach...()`, `detach...()`, `sync...()`;
- `sync` usa un diff fra associazioni correnti e richieste;
- attach/detach agiscono solo sulla pivot e non cancellano record target.

## UI
Il Builder mostra una sezione `Relazioni N:N (pivot scaffolding)` separata dalle hasMany.
Non viene generato un editor N:N automatico: i mutator sono punti di estensione per lo sviluppatore.

## Sakila
Casi attesi:
- `film <-> actor` via `film_actor`;
- `film <-> category` via `film_category`.

Le preview hasMany tecniche delle pivot pure sono disabilitate per default per evitare duplicazione, ma la configurazione resta esplicita.

## Builder iconography

The Builder now uses a consistent visual legend for field and relation options. The same icon meanings are documented in **Documentazione → Guida ai campi del Builder** so developers can read the configuration panel faster without relying only on labels.


## Create/Edit operativo N:N
Le pivot pure abilitate possono essere selezionate nel Create e sincronizzate nell'Edit. Il form invia `_many[relationKey][]`; il Model valida server-side l'esistenza di ogni ID target e applica attach/detach per diff nella stessa transazione del record principale. Le pivot arricchite restano escluse.


### Label N:N composte
Le opzioni delle relazioni N:N usano una label composta quando il target espone campi descrittivi complementari (es. `actor.first_name + actor.last_name`). L'ID resta il valore tecnico inviato e validato server-side.
