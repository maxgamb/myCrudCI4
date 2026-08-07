# myCrudGpt 2.7.4 — stabilità e performance

La 2.7.4 mantiene le architetture progressive della 2.7.3 e aggiunge strumenti di verifica e performance senza cambiare il contratto di staging `app/Generated/`.

## Test automatici

```bash
php spark mycrud:test-all agenda
```

Genera Basic, Standard e Full in cartelle temporanee isolate e verifica componenti attesi/assenti, placeholder e sintassi PHP. Le cartelle temporanee vengono eliminate al termine.

## Analisi schema e indici

```bash
php spark mycrud:doctor agenda
```

Mostra stima righe, primary key, indici, campi configurati per ricerca/ordinamento e dimensione/modalità delle relazioni.

## EXPLAIN

```bash
php spark mycrud:doctor agenda --explain
# oppure
php spark mycrud:explain agenda
```

Esegue `EXPLAIN` sulla query lista configurata (SELECT/JOIN/soft delete) e su un filtro secondario indicizzato quando disponibile. Non modifica i dati.

## Benchmark

```bash
php spark mycrud:benchmark agenda --iterations 5 --per-page 50
# oppure
php spark mycrud:doctor agenda --benchmark
```

Misura COUNT, prima pagina, pagina profonda e filtro indicizzato usando la struttura della lista generata. Il benchmark è volontario perché `COUNT(*)` e OFFSET profondi possono essere costosi su dataset grandi.

## Relazioni grandi

`information_schema.TABLES.TABLE_ROWS` viene usato come stima leggera. Sopra `relationAjaxThreshold` (default 5.000) il Builder propone `Select AJAX`.

Il sito generato usa:

```text
GET /<crud>/relation-options/<campo>?q=testo
```

con whitelist Model di tabella/chiave/label, limite risultati e ricerca a prefisso. Il form e il filtro dinamico caricano soltanto i risultati richiesti.

## Configurazione

In `Config\MyCrud`:

```php
public int $relationAjaxThreshold = 5000;
public int $relationAjaxLimit = 20;
public int $relationAjaxMinimumChars = 2;
public int $benchmarkIterations = 5;
public int $benchmarkPerPage = 50;
```

## Separazione generatore / sito

- codice generatore: `App\Libraries\MyCrud\...`
- runtime del sito generato: `App\Libraries\Crud\...`
- output sicuro: `app/Generated/...`

Le librerie runtime del sito restano indipendenti da myCrudGpt e continuano a funzionare dopo la rimozione del generatore.
