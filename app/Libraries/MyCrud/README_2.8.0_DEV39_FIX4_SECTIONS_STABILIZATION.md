# myCrudGpt 2.8.0-dev39 fix4 — Sections Stabilization

Questa fix stabilizza il Builder delle sezioni senza modificare il comportamento CRUD.

## Regola canonica

- `section[field]` è l'unica fonte di verità inviata al server.
- Il drag&drop modifica la posizione visuale e aggiorna `section[field]`.
- Il menu `Sezione form` sposta il campo e aggiorna lo stesso `section[field]`.
- Prima di `Salva configurazione` e `Genera CRUD`, il Builder ricostruisce in modo deterministico `order[]` e `section[field]` dal DOM corrente.
- Se una sezione viene eliminata, i campi vengono assegnati a `__unsectioned` (`Senza sezione`).
- Le nuove sezioni vengono inserite prima dell'area di sistema `Senza sezione`, che resta sempre in fondo.

## Diagnostica

Aggiungendo `?mycrudSectionsDebug=1` all'URL del Builder, la console del browser espone `window.__mycrudSectionState` e una tabella campo → sezione al momento del caricamento/salvataggio.

La diagnostica è solo UI e non modifica la configurazione persistente.
