# myCrudGpt 2.8.0-dev34 STABLE — Pivot / Many-to-Many Scaffolding

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
Il CRUD generato include uno scaffold operativo N:N per Create/Edit; i metodi Model `attach/detach/sync` restano punti di estensione leggibili per lo sviluppatore.

## Sakila
Casi attesi:
- `film <-> actor` via `film_actor`;
- `film <-> category` via `film_category`.

Le preview hasMany tecniche delle pivot pure sono disabilitate per default per evitare duplicazione, ma la configurazione resta esplicita.


## Create/Edit operativo N:N
Le pivot pure abilitate possono essere selezionate nel Create e sincronizzate nell'Edit. Il form invia `_many[relationKey][]`; il Model valida server-side l'esistenza di ogni ID target e applica attach/detach per diff nella stessa transazione del record principale. Le pivot arricchite restano escluse.


## Layout form N:N

Ogni relazione N:N nel Create/Edit occupa `col-md-6` (6 colonne Bootstrap): due relazioni vengono quindi mostrate affiancate su schermi medi/grandi e tornano automaticamente a tutta larghezza su mobile. Il componente interno resta unico (`search-checkbox-badges`).


## Stato STABLE
Consolidata dopo collaudo su Sakila (`film <-> actor`, `film <-> category`).
Comprende le correzioni dev34 fix1-fix5: generazione Controller, rilevamento pivot via DbSchema, label composte, selettore N:N unificato `search-checkbox-badges` e layout Bootstrap `col-md-6`.
