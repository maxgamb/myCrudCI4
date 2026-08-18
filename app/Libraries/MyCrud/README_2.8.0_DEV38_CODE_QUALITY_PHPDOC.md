# myCrudGpt 2.8.0-dev38 — Code Quality & PHPDoc

Release di manutenzione orientata alla leggibilità del codice generato.

## Obiettivi

- nessun cambiamento funzionale dei CRUD;
- PHPDoc utile e uniforme su Controller, Model e Service;
- documentazione esplicita di responsabilità, input/output e relazioni;
- ServiceExtension documentati come area custom persistente;
- convenzioni generate leggibili anche senza conoscere internamente myCrudGpt.

## Regole di documentazione

Il PHPDoc deve spiegare ciò che non è ovvio dal nome del metodo. Sono privilegiati:

- responsabilità del livello architetturale;
- shape degli array con annotazioni `array<string, mixed>` / `list<...>`;
- eccezioni applicative;
- effetti sulle pivot e sulle relazioni;
- posizione dei punti di estensione custom.

Non vengono aggiunti commenti ridondanti che si limitano a ripetere il nome del metodo.

## Service Extension

`app/Services/Extensions/<Entity>ServiceExtension.php` rimane persistente, create-only e fuori da `app/Generated/`. Gli hook documentano parametri e valore di ritorno e ricordano che le query devono restare nel Model.

## Principio

Il codice generato deve essere una impalcatura leggibile e modificabile dallo sviluppatore, non una black box.


## fix1 — Capability-aware cleanup

La generazione ora rispetta in modo esplicito le capability reali della risorsa. SQL VIEW/read-only non generano metodi o helper di scrittura, Validation web/API di scrittura o ServiceExtension. Le risorse create-only non espongono Update/Delete non raggiungibili. API e OpenAPI generano write operations solo per risorse `writable`. Import, PHPDoc e helper sono emessi solo quando realmente utilizzati.


## fix2 — Capability/PHPDoc consistency

- Import `PageNotFoundException` corretto anche per risorse create-only.
- PHPDoc delle pivot pure allineato alla capability `Read + Create`.
- Contratto hook definitivo: `prepareData()` precede `beforeCreate()`/`beforeUpdate()`.
- Regression check per classi usate senza import e ordine hook Service.
