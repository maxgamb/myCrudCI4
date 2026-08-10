# myCrudGpt 2.8.0-dev24 — Short filter export fix

Bugfix minimale rispetto alla dev23.

- Gli export CSV/Word conservano i filtri rapidi presenti nella URL corrente, ad esempio `?title=ZHIVAGO+CORE`, anche quando la tabella è stata aggiornata via AJAX e il form filtri non è stato ricostruito.
- Vengono copiati solo i campi presenti nella whitelist `simpleFilterFields`, la stessa logica usata server-side da `CrudListRequest`.
- Il contesto di navigazione continua a conservare solo le FK.
- Nessuna altra modifica a CRUD, toolbar, export limits o configurazioni.
