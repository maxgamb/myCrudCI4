# Testing

myCrudCI4 has two complementary test levels.

## Generator regression

```bash
php spark mycrud:test <table>
php spark mycrud:test-all <table>
```

These validate generator behavior and persistent configuration workflows.


## Dashboard regression suite

```bash
php spark mycrud:test-dashboard
```

This project-wide suite checks generated Dashboard staging files, configuration-array boundaries, typed DTO return contracts, object-first Controller/View usage, `RecentRecord` preservation, generation-time concrete Model wiring, and a runtime `DashboardService::build()` smoke test.

A healthy frozen Dashboard 2.0 baseline should complete with no FAIL/WARN and no skipped runtime smoke test when the Dashboard is published.

## Generated CRUD contracts

```bash
php spark mycrud:test-generated <table>
```

Depending on architecture and enabled features, generated tests can include:

- Structure Contract;
- Validation Contract;
- API Resource Contract;
- OpenAPI Contract;
- Shield Security Contract;
- MCP Foundation Contract;
- MCP Resource Security Contract.

Generated test scaffolds are published under:

```text
tests/Generated/MyCrud/<Entity>/
```

A CRUD must be generated and published before `mycrud:test-generated` can execute
its current contract tests.


## 2.9.1 regression coverage

The consolidation line adds explicit regression coverage for the two write
paths that were fixed during 2.9.1 development.

### Nullable foreign keys

Generated web CRUD and Service code must normalize an empty optional foreign-key
value to `NULL` before persistence.

Example:

```text
film.original_language_id = ''
→ NULL
```

Required foreign keys are not changed.

### Many-to-many related create

When `Create new related record` is enabled, regression checks verify:

- the option survives persistent configuration save/reload;
- generated validation exposes relation-specific rules;
- Controller parses and validates the inline target payload;
- Service propagates the new-target payload;
- Model creates the target inside the main transaction;
- the new target ID is included in pivot synchronization.

Recommended verification:

```bash
php spark mycrud:test-generated film
php spark mycrud:test-all film
php spark mycrud:doctor film
```
