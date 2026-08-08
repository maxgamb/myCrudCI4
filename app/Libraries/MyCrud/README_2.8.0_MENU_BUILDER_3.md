# myCrudGpt 2.8.0-dev7 — Menu Builder 3

## Obiettivo

Il Menu Builder non prova più a dedurre automaticamente la struttura funzionale dell'applicazione dal database.

Una foreign key descrive una relazione tecnica e un prefisso descrive una convenzione di naming: nessuno dei due segnali è sufficiente per decidere come deve essere organizzata la navigazione di un gestionale reale.

## Strategia dev7

- tutte le tabelle/CRUD partono come **voci non assegnate**;
- lo sviluppatore crea gruppi e sottogruppi funzionali;
- le voci possono essere trascinate tra gruppi/sottogruppi;
- è disponibile la selezione multipla con assegnazione a un gruppo;
- è possibile creare un gruppo direttamente dalla selezione;
- le foreign key vengono mostrate esclusivamente nel pannello **Relazioni SQL**;
- `Seleziona correlate` seleziona le tabelle collegate senza assegnarle automaticamente;
- sono supportate voci manuali indipendenti dal DB;
- label, route, icone, preferiti e ordine restano modificabili;
- l'anteprima verticale/orizzontale usa la stessa configurazione finale.

## Principio

```text
Schema DB
   │
   ├─ tabelle disponibili
   └─ relazioni SQL informative
             │
             ▼
        Menu Builder
             │
     decisione sviluppatore
             │
             ▼
Generated/Config/Menu.php
Generated/Views/layouts/_menu*.php
```

Nessuna relazione o convenzione di nome sposta automaticamente una voce.

## Sicurezza

Come nel resto di myCrudGpt, il Menu Builder scrive esclusivamente in `app/Generated/`.
