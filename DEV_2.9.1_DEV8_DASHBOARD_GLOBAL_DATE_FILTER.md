# myCrudCI4 2.9.1-dev8 — Dashboard Global Date Filter

Baseline: `2.9.1-dev7`.

## Builder

Dashboard-level settings:

```text
Global date filter
- Enabled
- Label
```

Per widget:

```text
Global period mapping
- Date field
```

Only DATE/DATETIME/TIMESTAMP fields from the current configured CRUD are
available.

## Runtime

Generated Dashboard route accepts:

```text
?from=YYYY-MM-DD&to=YYYY-MM-DD
```

The generated Controller validates both values and normalizes reversed ranges.

## Query flow

```text
Global From/To
→ DashboardController
→ DashboardService
→ widget-specific date field
→ DashboardQuery or existing CRUD Model
```

The global date range combines with the local widget filter introduced in dev7.
