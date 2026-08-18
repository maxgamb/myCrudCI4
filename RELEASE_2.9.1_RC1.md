# myCrudCI4 2.9.1-RC1

## Status

Release Candidate 1. Feature set frozen.

The RC readiness matrix is green for the representative CRUDs `film`, `customer`, `staff`, `store`, and `rental`, including generated tests, API/OpenAPI, query layer, Dashboard, Shield contracts, CLI documentation, and Architecture/Builder guards.

## Baseline

- Explicit/static relation methods generated at generation time; no metadata-driven runtime relation dispatcher.
- Model layer owns reads and relation queries.
- Service layer owns writes and transactional orchestration when the selected architecture enables Services.
- Basic, Standard, and Full generation paths remain covered by regression commands.
- Persistent Builder configuration remains the source of customization intent; database/schema facts are reread from the schema.
- Dashboard object/DTO boundaries and generated runtime are covered by dedicated regression checks.
- Shield keeps web CRUD and REST API authorization/filter configuration separate.
- MCP remains read-only and capability-driven.
- OpenAPI generated contracts are capability-aware, including CRUDs with all API operations disabled.
- Related Create UI uses one project-wide offcanvas width from `Config\MyCrud::$relationOffcanvasWidth`, default `640` px.
- M2M form panel width remains separate and can be persisted per relation through `formWidth`.

## RC policy

From this baseline to 2.9.1 final, accept only release-blocking bug fixes, regression fixes, documentation corrections, and packaging/release corrections. Defer new features and architecture changes.

## Verification

Before promoting RC1 to stable, run:

```bash
php spark mycrud:test-all film
php spark mycrud:release-check film customer staff store rental
```

For a full configured-project refresh when required:

```bash
php spark mycrud:generate-all --force
php spark mycrud:publish-all --force
```

Then rerun the RC readiness matrix.
