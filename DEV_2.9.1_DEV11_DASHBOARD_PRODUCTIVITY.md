# myCrudCI4 2.9.1-dev11 — Dashboard Builder Productivity

Baseline: `2.9.1-dev10`.

## Live preview

Every widget card contains a lightweight Builder preview.

The preview does not query application data. It reflects the configured widget
shape:

- KPI;
- chart;
- Recent-record table;
- quick link.

## Recent columns

Recent-record widgets can select fields explicitly and change their generated
order with Up/Down controls.

The persistent configuration stores the ordered `recentFields` list.
DashboardGenerator validates all fields against the current CRUD before
generation.

## Date grouping

Grouped charts using a date-compatible group field expose:

```text
raw
day
month
year
```

Generated DashboardQuery has driver-aware date expressions for:

- MySQL / MariaDB;
- PostgreSQL;
- SQLite.

Unknown drivers fall back to raw grouping.
