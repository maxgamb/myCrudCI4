# myCrudCI4 2.9.1-dev7 — Dashboard Presentation & Filters

Baseline: `2.9.1-dev6`.

## KPI presentation

KPI widgets support:

- 0–4 decimals;
- optional prefix;
- optional suffix;
- compact card layout.

The DTO keeps the original numeric value; formatting is presentation-only.

## Widget filters

One optional filter can be configured per data widget.

Supported operators:

- eq
- neq
- gt
- gte
- lt
- lte
- contains
- starts_with

The selected field must belong to the current configured CRUD. Dashboard
generation revalidates the field and ignores stale or invalid filter
definitions.

Aggregate widgets apply the filter in `DashboardQuery`.
Recent-record widgets apply the same validated filter to the reused generated
CRUD Model.

## Recent records

Recent records now use:

- fields configured as `Visible in list`;
- configured field labels;
- Entity property reads where Entity objects are returned.

This makes Dashboard record presentation consistent with CRUD configuration.

## Architecture

```text
Aggregate widget
→ DashboardQuery + safe filter
→ DTO
→ DashboardService
→ View

Recent records
→ existing CRUD Model + safe filter
→ Entity
→ configured labels/fields
→ View
```
