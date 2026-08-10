# myCrudGpt 2.8.0-dev15 - Short Filter URLs

Consolidamento della navigazione filtri senza introdurre un secondo motore SQL.

## URL semplici

Un parametro GET che corrisponde a un campo filtrabile whitelist viene convertito internamente in un filtro `eq`:

```text
/film?language_id=1
```

è equivalente alla forma avanzata `filters[...]` con operatore `eq`.

I filtri dinamici `filters[...]` restano disponibili per operatori avanzati e AND/OR.

## Sicurezza

La forma corta è accettata solo per campi non sensibili, `searchable`, indicizzati/PK secondo la stessa whitelist della lista e con nome compatibile con un parametro GET semplice. Valori vuoti vengono ignorati. La validazione finale resta nel Model.

## Quick filter

I link rapidi generati nelle liste usano URL leggibili come:

```text
/film?language_id=1
```

La FK usa sempre il valore reale memorizzato (`1`), non la label mostrata (`English`). La paginazione conserva la sintassi corta finché l'utente non usa esplicitamente il builder dei filtri avanzati.
