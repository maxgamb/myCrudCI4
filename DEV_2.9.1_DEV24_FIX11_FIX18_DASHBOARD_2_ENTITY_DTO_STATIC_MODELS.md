# myCrudCI4 2.9.1-dev24-fix11-fix18 — Dashboard 2.0 Entity/DTO + static Models

Baseline: `2.9.1-dev24-fix11-fix17`.

## Goals

Dashboard runtime composition is now typed before the View boundary and Recent widgets no longer instantiate CRUD Models through runtime class names.

## DTO layer

Generated Dashboard files now include:

- `DTO/Dashboard/DashboardData.php` — typed Dashboard result;
- `DTO/Dashboard/DashboardWidget.php` — immutable widget envelope;
- `DTO/Dashboard/RecentRecord.php` — Entity-aware projection for recent records;
- existing `Kpi.php` and `SeriesPoint.php`.

Generated Models may return Entities, arrays, or ordinary objects. `RecentRecord` normalizes them before presentation and exposes only configured recent fields.

## Static Model wiring

Recent widgets are wired at generation-time. Generated `DashboardService` contains concrete imports and concrete instantiation such as:

```php
use App\Models\FilmModel;

$model = new FilmModel();
```

The previous runtime pattern:

```php
$modelClass = $widget['modelClass'];
$model = new $modelClass();
```

is no longer emitted.

This follows AR-002 / AR-009: when the generator already knows a class, it writes the concrete PHP class.

## View boundary

`DashboardService::build()` returns `DashboardData`. The Controller converts the DTO to the existing safe View payload using `DashboardData::toArray()`, keeping the visual Dashboard compatible while separating domain/query results from rendering.

## Compatibility

Dashboard configuration format, Builder UI, global filters, global date range, widgets, Chart.js rendering, and routes remain compatible.
