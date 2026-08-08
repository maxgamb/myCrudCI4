# myCrudGpt 2.8.0-dev9 — Quick FK deterministic default

La generazione `mycrud/quick` non prova più a indovinare un campo descrittivo per le foreign key.

Per ogni relazione `belongsTo`, la Quick usa come `relationDisplayField` la colonna del padre realmente referenziata dalla FK (`parentKey`) e lascia vuoto `relationDisplayTemplate`.

Esempio:

- `agenda.hotel_id -> hotels.hotel_id`
- Quick: `displayField = hotel_id`
- Builder: lo sviluppatore può successivamente scegliere `hotel_nome` oppure un template come `{codice} - {nome}`.

Il comportamento è applicato prima del salvataggio in `app/MyCrudConfig/<tabella>.php`, quindi la configurazione persistente rispecchia esattamente il default Quick.
