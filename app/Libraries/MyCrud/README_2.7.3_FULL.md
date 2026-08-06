# myCrudGpt 2.7.3 — generatore Full unificato

La versione resta **2.7.3**. Basic, Standard e Full vengono normalizzati sullo stesso `FullCrudGenerator`; non esistono più tre architetture di output differenti.

## Motore elenco

- tabella Bootstrap;
- Pager CodeIgniter 4;
- caricamento AJAX con fallback GET senza JavaScript;
- filtri server-side proposti sui campi che guidano un indice;
- ordinamento consentito solo tramite whitelist;
- selezione dei soli campi visibili;
- esportazione CSV dei record filtrati, a blocchi e con protezione CSV injection;
- DataTables disattivato come motore predefinito.

## Struttura generata

I generatori scrivono esclusivamente sotto `app/Generated/`, passando a `writeGenerated()` percorsi che iniziano con `Generated/`.

Esempi:

```php
$this->writeGenerated('Generated/Controllers/NomeController.php', $content, $force);
$this->writeGenerated('Generated/Views/tabella/index.php', $content, $force);
$this->writeGenerated('Generated/Routes/tabella.php', $content, $force);
```

Lo spostamento in `app/Controllers`, `app/Models`, `app/Views` e nelle altre cartelle operative rimane manuale.

## Layout

- interfaccia myCrudGpt: `layouts/default_crud`;
- viste applicative generate: `layouts/default_app`.

## File principali

- `Generators/FullCrudGenerator.php`: coordinatore unico;
- `Core/CrudGeneratorService.php`: facade compatibile;
- `Generators/ModelGenerator.php`: query lista, conteggio, filtri, Pager e CSV;
- `Generators/ControllerGenerator.php`: HTTP, AJAX e download CSV;
- `Generators/Views/IndexViewGenerator.php`: index, filtri e tabella parziale;
- `Generators/RouteGenerator.php`: CRUD, CSV e API v1.
