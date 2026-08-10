# myCrudGpt 2.8.0-dev25 — Validation CHAR max_length bugfix

Bugfix minimale rispetto alla dev24.

- `CHAR(n)` non genera più `exact_length[n]`.
- `CHAR(n)` e `VARCHAR(n)` generano `max_length[n]`.
- `exact_length` resta una regola applicativa esplicita del Builder/programmatore, non dedotta automaticamente dal tipo SQL.
- `ValidationGenerator::messages()` resta invariato e continua a restituire `[]`, usando i messaggi standard CI4 salvo personalizzazioni future.
- Aggiunto controllo regressivo sintetico in `ArchitectureRegressionRunner`.
