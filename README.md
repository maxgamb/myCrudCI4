# myCrudGpt — pacchetto production

Generatore CRUD per CodeIgniter 4 con due modalità:

1. generazione automatica dalla struttura del database;
2. generazione personalizzata con ordinamento drag-and-drop, icone,
   tipi input, label, larghezze Bootstrap e attributi HTML.

## Architetture

### Basic

- Controller
- Model con `returnType = 'object'`
- Validation
- `index.php`, `view.php`, `create.php`, `edit.php`
- DataTables
- Routes

### Standard

- Basic
- Entity
- Service
- Model con Entity come `returnType`

### Full

- Standard
- API REST
- DataTables e filtri server-side

Tutte le view usano sempre oggetti:

```php
$row->campo
```

In Basic sono `stdClass`; in Standard/Full sono Entity.

## Installazione

Copia la cartella `app` dentro la root del progetto CodeIgniter 4.

In fondo a `app/Config/Routes.php` aggiungi:

```php
require APPPATH . 'Config/MyCrudRoutes.php';
```

Controlla:

```bash
php spark routes
```

Avvia:

```bash
php spark serve
```

Apri:

```text
http://localhost:8080/mycrud
```

## Generazione da browser

Automatica:

```text
/mycrud/auto/nome_tabella
```

Personalizzata:

```text
/mycrud/builder/configure/nome_tabella
```

## Generazione da CLI

```bash
php spark mycrud:generate clienti
php spark mycrud:generate clienti --architecture standard
php spark mycrud:generate clienti --architecture full --force
```

## Output

I file vengono scritti nello staging:

```text
app/Generated/
├── Controllers/
│   └── Api/
├── Entities/
├── Models/
├── Routes/
├── Services/
├── Validation/
└── Views/
```

I file hanno già namespace finali (`App\Models`, `App\Controllers`, ecc.).
Dopo la revisione, spostali manualmente nelle rispettive directory di `app`.

## Quattro view

Ogni CRUD genera sempre:

```text
index.php
view.php
create.php
edit.php
```

`index.php` comprende:

- DataTables server-side;
- ordinamento;
- ricerca globale;
- filtri per colonna;
- pulsanti con icone;
- export CSV, Excel, copia e stampa;
- salvataggio dello stato;
- azioni visualizza, modifica ed elimina.

## Relazioni

Le foreign key `belongsTo` vengono:

- rilevate dal database;
- rese `select` nel form;
- caricate come opzioni nel controller;
- mostrate nelle query con join e alias.

Le relazioni many-to-many vengono rilevate nella configurazione, ma la
sincronizzazione automatica della pivot non viene ancora generata: richiede
regole applicative specifiche e deve essere implementata nel Service.
