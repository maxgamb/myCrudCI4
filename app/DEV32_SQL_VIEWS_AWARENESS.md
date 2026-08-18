# myCrudGpt 2.8.0-dev32 — SQL Views Awareness — STABLE

Base: 2.8.0-dev31 STABLE.

Obiettivo: rendere esplicito e pulito il supporto alle SQL VIEW già presente, senza creare un sottosistema speciale.

## Regole

- BASE TABLE: comportamento CRUD normale.
- VIEW: scaffolding read-only per sviluppatore.
- Il Builder mostra VIEW SQL / Read only.
- Le VIEW non espongono controlli di form/scrittura nel Builder.
- Nessun Create/Edit/Delete/Soft Delete o scrittura relazionale viene generato per una VIEW.
- Restano Index, Pager, filtri configurabili, CSV/Word.
- Full aggiunge API GET, Resource e OpenAPI read-only.
- Non vengono inventati indici, FK o updatability della VIEW.
- Basic/Standard/Full restano livelli di impalcatura, non livelli di automazione applicativa.

La filosofia resta: generare codice leggibile e modificabile che elimini il lavoro ripetitivo, lasciando allo sviluppatore le decisioni applicative.

## Stato

`2.8.0-dev32` è consolidata come **STABLE**. Le evoluzioni successive devono partire da questa base.
