# myCrudGpt 2.2 — Test, diagnostica e stabilità

## Nuovi comandi

- `php spark mycrud:doctor`
- `php spark mycrud:test <table>`

## Controlli inclusi

- file essenziali dell'installazione;
- directory di generazione;
- template obbligatori;
- template con `include`/`require` pericolosi;
- placeholder formali nei template;
- placeholder irrisolti nei file generati;
- lint PHP dei file generati;
- generazione reale Basic, Standard e Full;
- report CLI e JSON.

## Compatibilità

La release parte dalla baseline `app.zip` del 5 agosto 2026 e non modifica il comportamento funzionale di Auto mode, Builder, relazioni o template.
