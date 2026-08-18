# myCrudGpt 2.8.0-dev32 — STABLE

Base consolidata della linea 2.8 al 10 agosto 2026.

Base precedente: `2.8.0-dev31 STABLE`.

## Funzioni consolidate
- Tutte le funzioni consolidate in dev31 STABLE.
- Riconoscimento esplicito `BASE TABLE` / `VIEW` tramite `information_schema.TABLES`.
- SQL VIEW trattate come scaffolding read-only per lo sviluppatore.
- Badge `VIEW SQL` / `Read only` nel Builder.
- Builder ripulito per le VIEW: niente controlli di form/scrittura non pertinenti.
- Nessun Create/Edit/Delete/Soft Delete o scrittura relazionale generata per una VIEW.
- Index, Pager, filtri configurabili, CSV/Word mantenuti per le VIEW.
- Architettura Full: API GET, Resource e OpenAPI read-only.
- Nessuna inferenza artificiale di indici, FK o updatability della VIEW.
- Basic/Standard/Full restano livelli di impalcatura, non livelli di automazione applicativa.

## Filosofia
myCrudGpt genera un'impalcatura leggibile e modificabile che elimina il lavoro ripetitivo. Per le SQL VIEW non tenta di sostituirsi allo sviluppatore con logiche implicite o casi speciali difficili da mantenere.

## Fuori scope
- Scrittura su SQL VIEW, anche se tecnicamente updatable.
- Relazioni FK inventate o dedotte dal nome delle colonne della VIEW.
- Relational Edit.
- Gestione hasMany editabile.
- Pivot / many-to-many.
- Cascate relazionali multilivello.
