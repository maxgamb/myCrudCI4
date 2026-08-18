# myCrudCI4 2.9.1-dev3-CONSO

Baseline: `2.9.1-dev2-fix12`.

This is a consolidation candidate, not a feature release.

## Consolidated behaviors

### Nullable foreign keys

Optional FK fields submitted as an empty HTML value are normalized:

```text
'' -> NULL
```

The contract is checked in generated web CRUD and Service write paths.

### Many-to-many related create

`Create new related record` is consolidated across:

```text
Builder
→ persistent configuration
→ Validation
→ Controller
→ Service
→ Model transaction
→ pivot synchronization
```

### Builder UI

Availability is shown once, directly beside the
`Create new related record` option.

## Regression additions

- `ConfigurationRegressionRunner` checks persistence of `createRelatedEnabled`;
- `ArchitectureRegressionRunner` checks nullable FK normalization;
- `ArchitectureRegressionRunner` checks generated M:N related-create plumbing;
- generated Validation contract tests check M:N related-create rule presence.

## Stable-candidate test sequence

```bash
php spark mycrud:generate film --force
php spark mycrud:diff film
php spark mycrud:publish film --dry-run
php spark mycrud:publish film --force
php spark mycrud:test-generated film
php spark mycrud:test-all film
php spark mycrud:doctor film
php spark mycrud:check-api film
php spark mycrud:check-query-layer film
```
