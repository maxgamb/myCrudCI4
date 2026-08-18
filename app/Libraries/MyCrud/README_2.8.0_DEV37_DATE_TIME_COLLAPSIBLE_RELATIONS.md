# myCrudGpt 2.8.0-dev37 — Date/Time Initial Values & Collapsible Relations

## Date/Time Initial Values
Per campi temporali scrivibili il Builder mostra `Valore iniziale nel Create`: Nessuno, Oggi, Data e ora corrente, Ora corrente, Personalizzato. È un default della UI del Create: `old()`, contesto e valori Edit hanno precedenza. I campi `databaseManaged` non possono essere configurati e restano DB-authoritative.

## Relazioni collassabili nella View
I pannelli `hasMany` e N:N possono essere collassabili e inizialmente aperti o chiusi. Header, conteggio e azioni restano sempre visibili. Il contenuto tabellare viene nascosto tramite Bootstrap Collapse, senza cambiare query o persistenza.

## Builder
- hasMany: `Pannello figli collassabile`, `Chiuso all'apertura`.
- N:N: `Pannello collassabile nella View`, `Chiuso all'apertura`.
- campi temporali: `Valore iniziale nel Create`.

## Compatibilità
Restano invariati databaseManaged, SQL VIEW read-only, Relational Create, N:N sync, Cascaded Navigation e Service Extension persistenti fuori da `app/Generated/`.
