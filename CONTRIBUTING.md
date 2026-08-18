# Contributing to myCrudCI4

myCrudCI4 is a generator: changes to the generator must preserve the architecture of both the generator and the code it emits. Read `docs/development/ARCHITECTURE.md` and `docs/development/ARCHITECTURE_RULES.md` before changing generator code.

## Development workflow

1. Start from the current frozen baseline.
2. Identify whether the change belongs to schema inspection, configuration, generation, runtime infrastructure, UI, API/OpenAPI, MCP, diagnostics, or documentation.
3. Prefer generation-time decisions over runtime discovery.
4. Update the smallest responsible generator/layer.
5. Generate representative CRUDs (at least a simple FK CRUD and an N:N CRUD).
6. Review `app/Generated/` before publishing.
7. Run regression and architecture checks.
8. Update canonical documentation and `mycrud:ai-context` whenever architecture, security, Builder workflow, or a generated contract changes.

## Required checks

```bash
php spark mycrud:generate-all --force
php spark mycrud:test-all customer
php spark mycrud:test-all film
php spark mycrud:test-dashboard
php spark mycrud:check-query-layer customer
php spark mycrud:check-query-layer film
php spark mycrud:check-api film
php spark mycrud:ai-context
```

Use `php spark mycrud:publish-all --force` only after reviewing generated output.

## Pull-request / change checklist

- [ ] No runtime Model/Service/table resolver was introduced for schema-known relations.
- [ ] SQL/query composition remains in Models.
- [ ] Standard/Full write orchestration remains in Services.
- [ ] Resources remain output-only.
- [ ] Dashboard 2.0 object boundaries remain typed through Controller/View.
- [ ] Shield Web CRUD (`crudSecurity`) and REST API (`apiSecurity`) remain independent.
- [ ] Builder navigation avoids nested vertical scrolling; Parent database tables remains sticky-only.
- [ ] `app/Generated/` remains replaceable.
- [ ] Persistent extension files are never overwritten.
- [ ] Feature-aware generation does not emit unused APIs/helpers.
- [ ] Web, REST, OpenAPI, MCP, CLI diagnostics, tests and AI context were evaluated.
- [ ] Regression tests pass.

See `docs/development/ADDING_A_FEATURE.md` for the complete feature workflow.
