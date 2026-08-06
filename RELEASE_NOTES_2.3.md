# myCrudGpt 2.3 - Builder UX e visibilità campi

Baseline: myCrudGpt 2.2 con diagnostica.

## Novità

- Ricerca rapida dei campi nel Builder.
- Filtri per required, nullable, foreign key, hidden, readonly, sensibili e visibilità elenco.
- Indicatore delle modifiche non salvate e avviso prima di uscire.
- Azioni rapide: mostra tutti, default elenco, proteggi campi sensibili.
- Configurazione per campo:
  - visibleIndex
  - visibleView
  - visibleForm
  - searchable
  - sortable
  - exportable
  - sensitive
- Default intelligenti derivati dal DB.
- Rilevamento automatico di password, PIN, token e chiavi.
- I campi sensibili sono esclusi automaticamente da elenco, ricerca ed export.
- Il form di modifica non ripropone il valore dei campi sensibili.
- Index, Detail, Form e Controller rispettano le nuove impostazioni UI.
- Anteprima form coerente con visibleForm.

## Compatibilità

Le configurazioni precedenti restano valide. In assenza della sezione `ui`, i generatori applicano default compatibili.

## Verifica

- 159 file PHP verificati con `php -l`.
- Nessun errore sintattico rilevato.
