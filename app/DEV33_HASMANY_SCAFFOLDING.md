# myCrudGpt 2.8.0-dev33 — HasMany Contextual Scaffolding

Base: **2.8.0-dev32 STABLE**.

## Obiettivo

Generare una impalcatura semplice e modificabile per le relazioni figlie reali rilevate dalle FK, senza introdurre editor ricorsivi o logiche applicative nascoste.

## Cosa genera

Per ogni `hasMany` abilitata:

- query dedicata nel Model del padre (`get<Child>By<ForeignKey>()`);
- caricatore aggregato `loadHasMany()` con limite `N + 1`;
- partial dedicato `Views/<parent>/_children_<relation>.php`;
- include del partial nella View dettaglio del padre;
- pulsante **Nuovo figlio** opzionale, usando il normale FK Context del Create;
- contesto parent esplicito (`_parent_field`) derivato da whitelist schema: il Create figlio conosce il padre da cui è stato aperto;
- dopo il salvataggio del figlio, ritorno automatico alla View del padre; anche **Annulla** torna al padre senza perdere il contesto;
- pulsante **Vedi tutti** opzionale e sempre disponibile nel pannello, con filtro sulla FK;
- pulsante dettaglio figlio opzionale quando il child ha identità singola.

## Filosofia

Il partial e il metodo Model sono punti di estensione espliciti. myCrudGpt elimina il lavoro ripetitivo ma lascia allo sviluppatore il controllo sull'applicazione.

La differenza rispetto alla preview hasMany già presente nelle versioni precedenti è il **flusso navigabile parent → child → parent**: non viene aggiunto un editor inline, ma viene generata l'impalcatura di navigazione necessaria per lavorare realmente sul figlio mantenendo il contesto del padre.

Non vengono introdotti:

- editing inline dei figli;
- cancellazioni AJAX;
- form ricorsivi parent → child → grandchild;
- pivot many-to-many (rimandate a una release dedicata).

## Configurazione Builder

Per ogni relazione figlia si possono configurare:

- Attivo;
- titolo e icona;
- limite preview (1–200);
- mostra conteggio;
- mostra **Nuovo figlio**;
- mostra **Vedi tutti**;
- mostra dettaglio figlio;
- colonne visualizzate.

## Flusso generato

Esempio `customer -> rental`:

```text
Customer View
  -> Nuovo Rental
     /rental/create?customer_id=<id>&_parent_field=customer_id
  -> Create Rental con FK validata
  -> Salva
  -> ritorno automatico a /customer/view/<id>
```

`_parent_field` non contiene una tabella arbitraria: il Controller figlio la risolve contro `PARENT_CONTEXT_FIELDS`, whitelist generata esclusivamente dalle FK reali dello schema.

## Relational Create parent validation refinement

Il partial del parent creato inline riusa le policy tecniche derivate dallo schema anche per i campi del parent:

- validazione client HTML (`required`, tipo email/date/number, `maxlength`, `min`, `step`);
- FK interne al parent rese come select descrittive quando la relazione è in modalità select;
- validazione server CI4 con le stesse regole schema-driven, incluse `is_not_unique[parent.key]` per le FK;
- PK auto increment e campi database-managed esclusi;
- errori namespaced per campo (`<fk>__related__<field>`) e riapertura dell'Offcanvas tramite `old(_related_new)`.

La validazione server resta autoritativa; gli attributi HTML servono solo al feedback immediato lato client.
