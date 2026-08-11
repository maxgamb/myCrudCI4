# myCrudGpt 2.8.0-dev32 — Relational Edit

Base: `2.8.0-dev31 STABLE`.

Relational Edit consente, su una FK `belongsTo`, di modificare il record padre già collegato senza abbandonare l'Edit del figlio. La UI usa `input-group + Bootstrap Offcanvas` e un partial `_related_edit_<fk>.php`.

## Sicurezza
La PK del padre non viene accettata dal POST: il Model rilegge il record figlio originale e ricava da lì la FK. Se la FK viene cambiata nel form, il pulsante Modifica padre viene disabilitato lato client. Parent e child vengono aggiornati nella stessa transazione.

## Scope
Un solo livello child -> parent. Nessun edit ricorsivo, hasMany o pivot in dev32.
