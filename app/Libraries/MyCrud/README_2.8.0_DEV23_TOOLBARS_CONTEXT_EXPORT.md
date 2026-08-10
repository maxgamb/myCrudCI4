# myCrudGpt 2.8.0-dev23 — Toolbar, FK context, text preview, export safety

- Toolbar coerenti:
  - Index: Nuovo, CSV, Word (+ Cestino quando Soft Delete è attivo).
  - View: Nuovo, Lista, Modifica, Cancella, Stampa.
  - Create: Lista; il submit Salva resta nel form.
  - Edit: Nuovo, Lista, Visualizza, Cancella; il submit Salva resta nel form.
- Le FK presenti come parametri semplici nella query string vengono mantenute nelle azioni, nei form, nei redirect POST e negli export. Solo campi realmente FK e compatibili con parametri GET semplici sono accettati come contesto.
- Il contesto di navigazione viene inviato nei form come `_context[...]` e rimosso dal payload prima dell'accesso al Model.
- MEDIUMTEXT e LONGTEXT vengono abbreviati solo in index e tabelle hasMany. I limiti sono configurabili (`mediumTextPreviewLength`, `longTextPreviewLength`). View, form ed export mantengono il contenuto completo.
- Gli export continuano a usare chunk/cursore. Sono aggiunti limiti specifici per export senza filtri (`csvUnfilteredMaximumRows`, `wordUnfilteredMaximumRows`) oltre ai limiti massimi assoluti.
- Default dev23: CSV 150000 max / 25000 senza filtri; Word 10000 max / 5000 senza filtri.
