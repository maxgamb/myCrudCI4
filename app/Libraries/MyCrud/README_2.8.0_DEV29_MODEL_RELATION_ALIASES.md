# myCrudGpt 2.8.0-dev29 — Model relation aliases

Bugfix/refinement mirato del Model generato.

- Le label delle relazioni `belongsTo` usano ora l'alias risultato `<foreign_key>__label` (es. `language_id__label`) invece dell'alias tecnico del JOIN.
- L'alias SQL del JOIN resta distinto (es. `language__language_id`) così due FK verso la stessa tabella non collidono.
- Ogni relazione padre viene dichiarata una sola volta in un metodo privato del Model; `baseBuilder()`, `listBuilder()` ed export richiamano quel metodo invece di duplicare il SQL del JOIN.
- Nel Model generato è presente un breve commento sulla FK e sull'alias restituito.
- Nessuna modifica alla struttura DB, ai Controller o alle policy di navigazione.
