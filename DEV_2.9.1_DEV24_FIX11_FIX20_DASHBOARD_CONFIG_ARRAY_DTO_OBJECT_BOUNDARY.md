# 2.9.1-dev24-fix11-fix20 — Dashboard config-array / DTO-object boundary

This fix corrects a boundary regression introduced while making the generated Dashboard object-first.

## Contract

- Builder/persisted Dashboard configuration remains plain arrays during generation.
- Generated runtime Dashboard data uses DTO objects (`DashboardData`, `DashboardWidget`, `RecentRecord`).
- Views consume DTO objects directly.

`DashboardGenerator::resolveWidgets()` must therefore use array access for its input configuration. Calling `->get()` there is invalid because those widgets have not yet been converted into runtime DTOs.
