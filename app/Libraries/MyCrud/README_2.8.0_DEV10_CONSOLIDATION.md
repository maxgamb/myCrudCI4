# myCrudGpt 2.8.0-dev10 — Consolidamento

Questa revisione non introduce nuove architetture CRUD. Consolida l’interfaccia e separa in modo esplicito le responsabilità:

- **Quick**: usa soltanto informazioni certe del database. Le FK sono rilevate, ma le opzioni di navigazione restano disabilitate fino a scelta esplicita nel Builder.
- **Builder**: raccoglie le decisioni applicative (descrizioni FK, link, filtri rapidi, context URL, ecc.).
- **Navbar mycrud**: rimossa la sezione Legacy dalla UI principale; le vecchie route/file non vengono cancellati da questa revisione.
- **Documentazione**: nuova pagina `/mycrud/docs` con workflow, architetture, configurazione persistente, relazioni, Menu Builder e comandi Spark.
- **Versione UI**: il badge della navbar mostra la versione reale del generatore invece di `Production`.

Il motore Basic/Standard/Full, staging sicuro, diff, doctor, benchmark, dashboard e Guided Menu Builder restano invariati.
