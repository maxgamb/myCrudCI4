# myCrudGpt 2.7.3 — Runtime CRUD e filtro dinamico

## Lato generatore

- `RuntimeSupportGenerator` crea una sola infrastruttura condivisa sotto `app/Generated/Libraries/Crud/`.
- Il runtime generato non dipende dal namespace `MyCrud` e continua a funzionare dopo la rimozione del generatore.
- `IndexViewGenerator` genera la whitelist dei campi disponibili nel filtro dinamico.
- `ModelGenerator` valida nuovamente campo e operatore prima di applicare ogni condizione SQL.
- Basic, Standard e Full conservano le rispettive architetture progressive.

## Lato sito generato

- `CrudListRequest` normalizza filtri, pagina, numero righe e ordinamento.
- `SubmissionGuard` gestisce i token monouso contro il doppio invio.
- `CrudInputProcessor` gestisce la normalizzazione comune dei dati del form.
- `CrudExporter`, `CsvWriter` e `WordHtmlWriter` centralizzano CSV e Word HTML.
- Il filtro è costruito a righe: Campo + Criterio + Valore + AND/OR, con aggiunta/rimozione dinamica.
- Elenco, CSV e Word riutilizzano lo stesso array di filtri e la stessa logica server-side nel Model.
- Tutte le viste continuano a usare solo classi Bootstrap standard e Bootstrap Icons.

## Refactoring Controller 2.7.3

Il Controller generato mantiene solo il flusso HTTP del CRUD. Il codice comune
non viene duplicato per tabella:

- `CrudExporter` unifica CSV e Word HTML e genera le intestazioni dal file lingua;
- `CrudListRequest` normalizza filtri dinamici, pagina e ordinamento;
- `SubmissionGuard` gestisce i token monouso contro il doppio invio;
- `CrudInputProcessor` esegue la pulizia meccanica dei dati form;
- Model e Service espongono metodi generici `exportRows()`, `countExportRows()` e
  `exportFields()` invece di metodi legati al solo CSV.

Basic continua a chiamare direttamente il Model. Standard e Full chiamano il
Service. Le differenze vengono risolte dal generatore e non tramite wrapper
ripetuti nel Controller del sito.

Nel filtro dinamico il selettore AND/OR appartiene alla riga corrente e collega
la condizione alla riga successiva. Il pulsante `+` inserisce la nuova riga
immediatamente sotto quella selezionata.
