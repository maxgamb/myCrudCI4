# myCrudCI4 2.9.1-dev24-fix11-fix19 — Dashboard 2.0 object-first View boundary

Baseline: `2.9.1-dev24-fix11-fix18`.

## Goal

Complete the DTO migration introduced in fix18 without converting Dashboard runtime data back to arrays before rendering.

## Runtime contract

```text
Model / Entity
    ↓
DashboardService
    ↓
DashboardData
    └── DashboardWidget[]
          ├── Kpi
          ├── SeriesPoint[]
          └── RecentRecord[]
    ↓
DashboardController
    ↓
View
```

`DashboardData`, `DashboardWidget`, `Kpi`, `SeriesPoint`, and `RecentRecord` remain objects up to the View.

## Intentional arrays

Configuration structures remain arrays where that is the natural representation: global filter definitions, active filter values, date-range metadata, labels, and other serialized Dashboard configuration. They are not domain records and are not converted into DTOs in this fix.

## Recent records

The previous fix created `RecentRecord` DTOs but flattened them back to arrays inside `DashboardService`. fix19 removes that conversion. The generated View reads configured values explicitly with `RecentRecord::value($field)`.

## Controller boundary

The generated Controller passes the `DashboardData` instance directly to the View and uses `$dashboard->title`; no `DashboardData::toArray()` call is emitted. `toArray()` remains available only as an optional serialization/debug boundary helper.

## Regression guard

`DashboardObjectViewBoundaryTest` verifies that generated Controller/View/Service code keeps the object-first contract and does not reintroduce array access for Dashboard/Widget records.
