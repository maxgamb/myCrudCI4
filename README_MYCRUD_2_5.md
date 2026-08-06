# myCrudGpt 2.5

Questa release parte dalla baseline `app.zip` indicata come stabile.

## Novità

- generazione automatica avanzata dal menu;
- scelta architettura Basic, Standard o Full;
- feature principali configurabili;
- riepilogo delle regole di validazione derivate dal database;
- `DatabaseValidationResolver` condiviso;
- validazione CI4 per nullable, lunghezze, numeri, date, email, URL, UNIQUE e FK;
- self relation gerarchica con select automatica;
- esclusione del record corrente dalla select padre;
- prevenzione di auto-riferimenti e cicli gerarchici;
- profondità massima configurabile;
- commenti essenziali e PHPDoc nei nuovi componenti;
- output della validazione formattato e compatto.

## Rotte nuove

- `GET mycrud/auto`
- `GET mycrud/auto/configure/{table}`
- `POST mycrud/auto/generate`
- `GET mycrud/auto/quick/{table}`

## Installazione

Unire la cartella `app/` con il progetto CI4 esistente. Non cancellare `BaseController.php` o altri file applicativi non presenti nel pacchetto.
