# myCrudGpt 2.8.0-dev32 — SQL Views Awareness — STABLE

Questa versione non introduce un sottosistema per le SQL VIEW: rende esplicito e più pulito il supporto che il generatore possedeva già.

- riconosce `BASE TABLE` e `VIEW` da `information_schema.TABLES`;
- mostra `VIEW SQL` / `Read only` nel Builder;
- tratta la VIEW come sorgente read-only;
- non genera Create/Edit/Delete/Soft Delete o scritture relazionali;
- mantiene Index, Pager, filtri configurabili, CSV/Word e API GET in Full;
- non inventa indici, FK o updatability della VIEW;
- nasconde nel Builder attributi e opzioni esclusivamente di form/scrittura;
- mantiene Basic/Standard/Full come livelli di impalcatura per lo sviluppatore.

Filosofia: myCrudGpt elimina il lavoro ripetitivo e lascia allo sviluppatore codice leggibile e punti di estensione, senza sostituirsi alle scelte applicative.

## Stato

`2.8.0-dev32` è consolidata come **STABLE**. Le evoluzioni successive devono partire da questa base.
