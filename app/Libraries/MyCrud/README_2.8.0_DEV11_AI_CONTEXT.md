# myCrudGpt 2.8.0-dev11 — AI Project Context

La dev11 aggiunge un generatore di contesto del progetto destinato ad agenti IA.

## Output

- `AI_PROJECT_CONTEXT.md`: regole generali, architetture, percorsi e mappa CRUD.
- `docs/ai/project.json`: snapshot strutturato machine-readable del progetto.
- `docs/ai/crud/<tabella>.md`: dettaglio di ogni CRUD configurato.

## Comandi

```bash
php spark mycrud:ai-context
php spark mycrud:ai-context agenda
```

## UI

`/mycrud/tools/ai-context`

## Sicurezza

Il contesto contiene metadati di schema e configurazione, non dati applicativi, credenziali, password o valori `.env`.
