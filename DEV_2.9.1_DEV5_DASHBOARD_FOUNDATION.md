# myCrudCI4 2.9.1-dev5 — Application Dashboard Foundation

## Goal

Add an application Dashboard without turning myCrudCI4 into a second reporting
framework and without duplicating existing CRUD logic.

## Architecture

```text
Recent records
→ existing generated Model
→ existing Entity when configured
→ DashboardService
→ Dashboard View

KPI / aggregate
→ DashboardQuery
→ lightweight DTO
→ DashboardService
→ Dashboard View
```

## First widgets

- KPI Count
- Recent records
- Quick link

## Persistent configuration

```text
app/MyCrudConfig/Dashboards/main.php
```

## Staging

```text
app/Generated/DTO/Dashboard/
app/Generated/Libraries/Dashboard/
app/Generated/Services/DashboardService.php
app/Generated/Controllers/DashboardController.php
app/Generated/Views/dashboard/index.php
app/Generated/Routes/dashboard.php
```

## Next layer

After validating this foundation:

- SUM / AVG / MIN / MAX KPI;
- grouped statistics;
- chart series;
- Dashboard filters;
- Entity computed-property selection for record widgets.
