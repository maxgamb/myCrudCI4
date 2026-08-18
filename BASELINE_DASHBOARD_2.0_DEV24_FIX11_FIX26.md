# Dashboard 2.0 architecture baseline — myCrudCI4 2.9.1-dev24-fix11-fix26

This document freezes the Dashboard 2.0 architecture validated after fixes 18–25. It is a guardrail for future changes, not a new runtime abstraction.

## Stable runtime contract

```text
Dashboard Builder / persisted configuration
                |
              arrays
                |
        DashboardGenerator
                |
      explicit generated PHP
                |
  DashboardService + concrete Models
                |
 Entity / query results -> Dashboard DTOs
                |
       DashboardController
                |
               View
             objects
```

### Ownership

- **Builder/configuration:** serializable arrays.
- **DashboardGenerator:** resolves schema/configuration at generation-time and emits explicit PHP.
- **Concrete generated Models:** recent-record/domain reads. Model classes and relation helper methods are wired at generation-time.
- **DashboardQuery:** read-only aggregate/grouped/statistical queries only. It must not become a generic domain Model.
- **Entity:** domain record representation returned by CRUD Models when configured.
- **Dashboard DTOs:** `DashboardData`, `DashboardWidget`, `Kpi`, `SeriesPoint`, and `RecentRecord` carry presentation data through runtime.
- **Controller:** receives `DashboardData` and passes it unchanged to the View.
- **View:** consumes DTO objects. It must not require `toArray()` conversion.

## Rules that must not regress

1. Do not introduce runtime Model resolvers or dynamic class names for recent widgets. Generate concrete imports and `new FilmModel()`-style code.
2. Do not use object access (`->get()`, `->type`) while iterating Builder/config arrays.
3. Do not convert `DashboardData`, `DashboardWidget`, or `RecentRecord` to arrays simply to feed the View.
4. Keep relation-aware Recent labels generation-time explicit, using generated Model option methods.
5. Keep SQL/aggregate logic out of Controllers and Views.
6. Keep DashboardQuery focused on aggregate/statistical reads.
7. Prefer readable generated PHP over a generic metadata-driven runtime engine.

## Supported Dashboard 2.0 widget baseline

- KPI count
- KPI aggregate (`SUM`, `AVG`, `MIN`, `MAX`)
- Grouped chart
- Recent records
- Quick link
- Global date filter and global filter mappings
- Relation-aware labels for selected Recent FK fields
- Semantic automatic titles and Builder chart-quality guidance

## Acceptance workflow

After a Dashboard change:

```bash
php spark mycrud:test-dashboard
php spark mycrud:test-all customer
```

Then generate and publish the configured Dashboard and verify it in the browser. The validated Sakila profile used during this freeze generated **10 Dashboard files and 6 widgets**, and the Dashboard runtime smoke test returned six typed `DashboardWidget` objects.

Expected dedicated suite baseline:

```text
WARN 0 | FAIL 0
```

The exact PASS count may grow when new guards are added; zero failures is the acceptance criterion.

## Extension rule

Future Dashboard work should first ask whether the requirement can be expressed in the Builder and translated to explicit generated code. New runtime indirection should be introduced only when explicit generated code cannot reasonably express the requirement.
