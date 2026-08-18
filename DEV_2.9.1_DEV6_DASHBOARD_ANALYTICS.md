# myCrudCI4 2.9.1-dev6 — Dashboard Analytics

Baseline: `2.9.1-dev5`.

## New widgets

### KPI Aggregate

Supported operations:

- SUM
- AVG
- MIN
- MAX

The value field must be numeric according to the current CRUD/database schema.

### Grouped Chart

Supported grouped operations:

- COUNT
- SUM
- AVG
- MIN
- MAX

Supported chart types:

- bar
- line
- doughnut

`COUNT` requires only a group field. Numeric operations require both a group
field and a numeric value field.

## Safety

Dashboard Builder field options are derived from configured CRUD schema.
DashboardGenerator resolves the CRUD again before generation and drops invalid
or stale widget definitions.

The generated DashboardQuery validates SQL identifiers and accepts only
supported aggregate operations.

## Architecture

```text
Recent records
→ generated CRUD Model
→ Entity when configured

KPI / grouped statistics
→ DashboardQuery
→ Kpi / SeriesPoint
→ DashboardService
→ View
```

No normal CRUD query is duplicated in DashboardQuery.
