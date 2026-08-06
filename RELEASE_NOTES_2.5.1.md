# myCrudGpt 2.5.1 — Quick globale sicura

## Funzioni

- selezione multipla delle tabelle;
- ricerca e seleziona tutte/nessuna;
- architettura Basic, Standard o Full;
- blacklist per nomi tabella e pattern;
- dry run senza scrittura;
- force overwrite con conferma rafforzata;
- continuazione dopo errori su singole tabelle;
- stati file distinti: created, overwritten, skipped, planned;
- report finale dettagliato;
- download report JSON.

## Rotte

- `GET mycrud/quick`
- `POST mycrud/quick/generate`
- `GET mycrud/quick/report/{file}`

## Installazione

Unire la cartella `app` con il progetto CodeIgniter esistente. Non cancellare i file applicativi non inclusi nel pacchetto.
