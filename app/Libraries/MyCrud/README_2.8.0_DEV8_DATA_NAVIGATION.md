# myCrudGpt 2.8.0-dev8 — Data Navigation / FK context

Questa iterazione mantiene il motore CRUD e il Guided Menu Builder della dev7 e aggiunge navigazione basata sugli indici e sulle foreign key.

## Relazioni descrittive

Per ogni FK il Builder permette di scegliere un `relationDisplayField` oppure un `relationDisplayTemplate` (es. `{cognome} {nome}`). La stessa definizione viene riutilizzata in lista, dettaglio, select, select AJAX e precompilazione contestuale. Le scelte sono salvate nella configurazione persistente del CRUD; lo schema DB resta autorevole.

## Navigazione lista

- valori indicizzati e realmente `searchable`: link di filtro rapido sulla stessa tabella;
- FK: label descrittiva con link al record padre;
- FK: icona filtro rapido opzionale sulla tabella figlia.

## Create contestuale

Una FK abilitata nel Builder può essere ricevuta via query string, ad esempio `camere/create?hotel_id=5`. Il valore viene verificato sulla tabella padre prima di essere passato al form. La priorità è `old()` > record in edit > contesto URL > valore vuoto. Funziona con hidden, select, select AJAX e normali input.

Nel form possono essere generati anche i link “apri padre” e “nuovo padre”.

## Sicurezza

La query string non può valorizzare campi arbitrari: vengono considerate soltanto FK con `acceptContext` abilitato. L'esistenza del record padre viene verificata server-side e la normale validazione DB viene comunque applicata al POST.
