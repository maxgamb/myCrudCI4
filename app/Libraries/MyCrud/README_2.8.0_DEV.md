# myCrudGpt 2.8.0-dev3 — configurazioni persistenti e rigenerazione controllata


## dev3 — versione centralizzata e diff leggibile

- La versione del generatore è definita una sola volta in `MyCrudVersion::VERSION`.
- `mycrud:diff` separa i file specifici del CRUD dai file condivisi.
- `mycrud:diff --details` mostra le righe aggiunte/rimosse per i file nuovi o modificati.
- Il motore di configurazione/rigenerazione validato in dev2 resta invariato.

## dev2 — correzione merge schema/config

- Lo schema DB resta autorevole anche con configurazioni persistenti obsolete.
- Campi e relazioni `hasMany` non più presenti nello schema vengono ignorati nel merge.
- I nuovi campi DB vengono aggiunti in coda all'ordine salvato.
- Model e Detail View ignorano in modo difensivo eventuali relazioni legacy incomplete.
- La regressione 2.8 verifica esplicitamente il caso di schema drift con relazioni rimosse.


La 2.8 parte dalla **2.7.4 STABLE** e non modifica il contratto delle architetture Basic / Standard / Full.

## Obiettivo

Separare definitivamente:

```text
schema DB
   +
scelte dello sviluppatore
   ↓
configurazione persistente
   ↓
generazione deterministica in app/Generated/
```

## Configurazioni persistenti

Le configurazioni vengono salvate in:

```text
app/MyCrudConfig/<tabella>.php
```

Il file è versionabile con Git e contiene solo le scelte dello sviluppatore: architettura, ordine campi, label, input type, UI, relazione AJAX/select, opzioni hasMany e feature configurabili.

Tipi DB, indici, foreign key e statistiche non vengono congelati nel file: vengono riletti dallo schema corrente prima di ogni generazione.

Compatibilità: le vecchie configurazioni JSON in `writable/mycrud/` restano leggibili e vengono convertite al nuovo formato al successivo salvataggio.

## Comandi

### Singolo CRUD

```bash
php spark mycrud:generate agenda
```

Se `app/MyCrudConfig/agenda.php` esiste, viene usato. Se non esiste, viene creato automaticamente dalla configurazione corrente.

Override temporaneo:

```bash
php spark mycrud:generate agenda --architecture full
```

Ignorare per una sola esecuzione la config persistente:

```bash
php spark mycrud:generate agenda --from-schema
```

### Tutti i CRUD configurati

```bash
php spark mycrud:generate-all
php spark mycrud:generate-all --force
```

Ogni tabella mantiene la propria architettura salvata.

### Diff senza scrittura

```bash
php spark mycrud:diff agenda
```

Genera temporaneamente in `writable/` e confronta la proposta con il codice operativo in `app/`.

Per confrontare con lo staging:

```bash
php spark mycrud:diff agenda --target generated
```

`--all` mostra anche i file invariati.

Per vedere anche l'entità delle modifiche:

```bash
php spark mycrud:diff agenda --details
```

Il report distingue `CRUD FILES` e `SHARED FILES`.

### Rigenerazione controllata

```bash
php spark mycrud:regenerate agenda --force
```

Prima mostra il riepilogo del diff verso `app/`, poi scrive **solo** in `app/Generated/`. Nessun file operativo viene sovrascritto.

## Schema drift

Ogni configurazione salva un `schemaFingerprint`. Se il DB cambia, `generate`, `generate-all`, `diff` e `regenerate` possono segnalare lo schema drift. La generazione usa comunque lo schema attuale e riapplica le scelte persistenti compatibili.

## Principio di sicurezza

La 2.8 mantiene la regola della 2.7.4:

```text
codice generato → app/Generated/
```

`app/MyCrudConfig/` contiene configurazioni del generatore, non codice applicativo generato.

## 2.8.0-dev4 - Project Dashboard

La home `/mycrud` diventa una Dashboard di progetto. La Dashboard legge in modo leggero tabelle DB, configurazioni persistenti, stime righe e relazioni e mostra:

- numero tabelle DB e CRUD configurati;
- conteggio Basic / Standard / Full;
- stato operativo / staging;
- architettura e versione con cui la configurazione è stata salvata;
- stima righe e numero di relazioni;
- azioni rapide Configura, Genera, Diff, Doctor e Apri CRUD;
- azioni globali Nuovo/Configura CRUD, Quick globale, Menu Builder e Genera tutti.

Le operazioni di generazione della Dashboard continuano a scrivere solo in `app/Generated/`.
Il diff resta non distruttivo e Doctor viene eseguito solo su richiesta, così l'apertura della Dashboard non avvia analisi pesanti su tutte le tabelle.


## dev38 — Code Quality & PHPDoc

Pulizia non funzionale del codice generato: PHPDoc uniforme, responsabilità dei layer esplicite e Service Extension documentati.
