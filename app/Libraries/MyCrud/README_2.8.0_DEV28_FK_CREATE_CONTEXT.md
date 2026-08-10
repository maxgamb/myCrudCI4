# myCrudGpt 2.8.0-dev28 — FK Create Context bugfix

Bugfix mirato alla precompilazione delle foreign key ricevute nella URL del Create.

Esempio:

```text
/rental/create?inventory_id=4581
```

Con una FK reale `rental.inventory_id -> inventory.inventory_id`, il campo `inventory_id` viene ora preimpostato a `4581`. Il Controller verifica prima l'esistenza del record padre tramite `relationOptionById()`; un valore inesistente produce 404 e non viene passato al form.

Regole:

- le FK reali hanno `relationNavigation.acceptContext = true` per default;
- la Quick imposta `acceptContext = true` insieme al `parentLink`;
- una scelta esplicita del Builder (`relationNavigationCustomized = true`) continua a prevalere e può disabilitare il comportamento;
- le vecchie config con `acceptContext = false` ma non personalizzate vengono migrate al nuovo default;
- il select resta modificabile: il contesto preimposta il valore ma non lo rende readonly;
- `old()` continua ad avere priorità dopo un errore di validazione;
- `_context[...]` continua a preservare la FK nei POST e nei redirect.

Nessun altro comportamento della dev27 è stato modificato.
