# myCrudGpt 2.8.0-dev1 — configurazioni persistenti e rigenerazione controllata

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
