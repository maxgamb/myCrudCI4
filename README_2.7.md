# myCrudGpt 2.7.0

CRUD API Generator costruito sulla Query Layer 2.6.1.

## Funzioni

- API REST versionate in `/api/v1/{resource}`
- GET lista e dettaglio
- POST create
- PUT update completo
- PATCH update parziale
- DELETE
- endpoint soft-delete opzionali
- paginazione `page` / `perPage` (massimo 100)
- ricerca `search`
- filtri whitelist `filter[campo]=valore`
- ordinamento whitelist `sort` / `direction`
- Resource con campi leggibili e scrivibili
- esclusione automatica dei campi sensibili
- risposte uniformi `data`, `meta`, `links`
- errori uniformi `error.code`, `error.message`, `error.fields`
- OpenAPI YAML per risorsa

## Verifica

```bash
php spark mycrud:check-api hotels
```

I file vengono generati in `app/Generated` e vanno poi spostati nella root `app` secondo il normale flusso del progetto.
