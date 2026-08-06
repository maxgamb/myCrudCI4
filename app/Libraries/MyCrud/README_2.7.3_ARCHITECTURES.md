# myCrudGpt 2.7.3 — architetture progressive

La versione resta **2.7.3** e mantiene tre architetture distinte. Il motore della lista è comune; cambiano i livelli applicativi generati.

## Componenti comuni

Basic, Standard e Full generano sempre:

- CRUD web completo;
- Model;
- Controller web;
- validazione client e server;
- viste Bootstrap con caricamento AJAX e fallback GET;
- Pager CodeIgniter 4;
- filtri server-side proposti sui campi che guidano un indice;
- ordinamento con whitelist;
- esportazione CSV filtrata e a blocchi;
- esportazione Word HTML filtrata e a blocchi;
- relazioni belongsTo e hasMany readonly;
- soft delete e cestino quando supportati dallo schema;
- CSRF e prevenzione del doppio invio.

## Basic

Flusso:

```text
Controller -> Model -> Database
```

File aggiuntivi non generati: Entity, Service, API, Resource e OpenAPI.

## Standard

Comprende tutto il Basic e aggiunge:

- Entity;
- Service;
- transazioni e regole applicative collocabili nel Service.

Flusso:

```text
Controller -> Service -> Model -> Database
```

## Full

Comprende tutto lo Standard e aggiunge:

- API REST v1;
- API Controller;
- Resource;
- validazione API separata;
- route API;
- OpenAPI.

Flusso API:

```text
API Controller -> Service -> Model -> Database -> Resource -> JSON
```

## Staging sicuro

Tutti i generatori scrivono esclusivamente sotto `app/Generated/`.
Ogni chiamata deve iniziare con `Generated/`, per esempio:

```php
$this->writeGenerated('Generated/Controllers/NomeController.php', $content, $force);
$this->writeGenerated('Generated/Routes/nome_tabella.php', $content, $force);
```

Lo spostamento nelle cartelle operative di `app/` resta manuale.

## Layout

- interfaccia myCrudGpt: `layouts/default_crud`;
- viste applicative generate: `layouts/default_app`.

## Coordinamento

- `CrudArchitectureGenerator`: coordinatore progressivo;
- `CrudGeneratorService`: facade principale;
- `FullCrudGenerator`: wrapper di compatibilità che forza Full;
- `ModelGenerator`: query, filtri, Pager ed esportazioni;
- `ControllerGenerator`: HTTP, AJAX, CSV e Word;
- `ApiValidationGenerator`: regole API separate;
- `RouteGenerator`: route web comuni e route API solo in Full.

## Correzioni applicate alla lista e alla sicurezza

- filtri racchiusi in `<details>` con titolo configurabile;
- pannello filtri aperto automaticamente quando esistono filtri attivi;
- partial `_pager.php` riutilizzato sopra e sotto la tabella;
- tabella Bootstrap compatta con `.table-sm`;
- dimensioni pagina consentite: 25, 50 e 100;
- richieste AJAX annullabili con `AbortController`;
- esportazioni CSV e Word coerenti con filtri e ordinamento, senza pagina/per-page;
- conteggio totale non filtrato memorizzato in cache per un intervallo configurabile;
- file lingua separati per ogni CRUD;
- password sottoposte a `password_hash()`;
- campi carta, CVV, token, segreti e password esclusi da lista, dettaglio, export e API;
- relazioni hasMany caricate con una sola query tramite `limit + 1`;
- nessun CSS personalizzato nelle viste generate: solo classi Bootstrap standard.
