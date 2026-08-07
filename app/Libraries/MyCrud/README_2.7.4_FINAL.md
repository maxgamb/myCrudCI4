# myCrudGpt 2.7.4 — versione definitiva

Questa build consolida la linea 2.7.4 senza cambiare le architetture progressive Basic / Standard / Full.

## Naming

- nessuna singularizzazione automatica dei nomi tabella;
- `clienti` -> `ClientiController`, `ClientiModel`, `ClientiService`, `ClientiEntity`;
- i campi database restano invariati (`hotel_id`, `preno_in_data`, ecc.).

## Navigazione applicazione

Il Menu Builder genera in staging:

- `Generated/Config/Menu.php`;
- `Generated/Views/layouts/_menu.php`;
- `Generated/Views/layouts/_menu_vertical.php`;
- `Generated/Views/layouts/_menu_horizontal.php`.

Il menu verticale usa gruppi Bootstrap collassabili, apre automaticamente il gruppo della route corrente ed evidenzia la voce attiva. Il menu orizzontale usa dropdown Bootstrap responsive ed evidenzia il gruppo/elemento corrente.

## Layout applicazione

`Views/layouts/default_app.php` è separato dal layout del generatore e include:

- Bootstrap 5.3.3;
- Bootstrap Icons 1.11.3;
- sidebar a larghezza stabile con scroll verticale indipendente;
- contenuto principale con scroll indipendente;
- supporto automatico menu `vertical` / `horizontal`;
- comportamento responsive;
- flash message centralizzati;
- tabelle CRUD compatte con celle `nowrap` e colonna Azioni sticky.

## Pager Bootstrap

Il Pager CI4 utilizza il template `bootstrap_full` registrato in `Config/Pager.php` e definito in `Views/Pagers/bootstrap_full.php`.

`ModelGenerator` usa `bootstrap_full` nelle chiamate a `service('pager')->makeLinks()`, eliminando l'output non formattato `123NextLast`.

## Routes

Le route restano modulari: un file per CRUD sotto `Generated/Routes/`, da spostare in `app/Routes/`.

## Staging

Tutto il codice prodotto dai generatori continua a essere scritto esclusivamente sotto `app/Generated/`.
