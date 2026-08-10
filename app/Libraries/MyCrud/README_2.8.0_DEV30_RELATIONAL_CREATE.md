# myCrudGpt 2.8.0-dev30 — Relational Create

Bugfix/consolidamento delle operazioni di creazione relazionali, senza modificare la policy di View/Edit/Delete su identità non ancora supportate.

## PK composta: Create consentito

Una BASE TABLE con primary key composta non viene più trattata come completamente read-only:

- Index: sì
- Create/Store web: sì
- View record: no
- Edit/Update: no
- Delete: no
- Export: sì

Il Create non deve identificare un record preesistente, quindi può usare in sicurezza tutti i campi della PK composta. Le operazioni record restano protette finché le route 2.8 usano una singola identità.

## Nuovo nelle relazioni figlie

Nella View del padre, ogni hasMany creabile espone `Nuovo` accanto a `Vedi tutti`.

Esempio:

`/film/view/996` → `/inventory/create?film_id=996`

La FK usata è quella esatta della relazione hasMany; il normale FK Context del Create la verifica e la precompila. Anche un child con PK composta può essere creato.

## Seleziona oppure crea nuovo record padre

Il Builder può abilitare per una FK compatibile la creazione del record padre nello stesso form del record corrente.

Flusso:

1. l'utente sceglie se usare il record esistente oppure `Nuovo <parent>`;
2. i dati del parent vengono validati con regole proprie;
3. il Model apre una transazione;
4. crea il parent e recupera la sua PK;
5. usa la PK come FK del record corrente;
6. crea il record corrente;
7. commit; qualsiasi errore esegue rollback.

La funzione è developer-driven: Quick non la abilita automaticamente. Il primo livello supporta un solo nuovo parent per FK, senza creazioni annidate.

## Sicurezza

- `_related` e `_related_new` sono campi infrastrutturali e vengono rimossi dal payload del record corrente.
- Le colonne del parent sono whitelisted dalla configurazione derivata dallo schema.
- VIEW, parent con PK composta e parent non rappresentabili in un normale form non vengono proposti per la creazione inline.
- I campi password del parent non sono gestiti dalla creazione inline di questo primo livello: se obbligatori, la funzione viene disabilitata per evitare inserimenti senza le trasformazioni del Service del parent.
- Il controllo delle normali FK e il FK Context continuano a essere verificati server-side.

## Consolidamento revisione

- I campi opzionali del parent creato inline vengono normalizzati prima dell'INSERT: stringa vuota → `NULL` per colonne nullable; per colonne con `DEFAULT` il campo viene omesso così il database applica il valore dichiarato nello schema.
- I valori `datetime-local` vengono normalizzati da `YYYY-MM-DDTHH:mm` al formato SQL prima dell'insert generico.
