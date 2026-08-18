# myCrudGpt 2.8.0-dev34 fix4 — Unified Many-to-Many selector

- Sostituito il `<select multiple>` con un unico componente Bootstrap N:N.
- Ricerca testuale locale, checkbox indipendenti e badge removibili dei selezionati.
- Eliminata la necessità di Ctrl/Cmd.
- Actor e Category usano la stessa UI.
- `_many_present[...]` e `_many[...][]` restano invariati: nessuna modifica alla logica server-side o transazionale.
- Gli ID continuano a essere ricontrollati server-side prima di attach/detach/sync.
- La UI è progettata per poter usare in futuro una sorgente AJAX senza cambiare esperienza utente.
