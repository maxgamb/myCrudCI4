# myCrudCI4 2.9.1-dev24-fix11-fix23 — Dashboard presentation polish

This change is intentionally limited to generated Dashboard presentation. The Dashboard 2.0 object boundaries frozen in fix22 remain unchanged.

## Changes

- Recent-record widgets use a responsive table with non-wrapping headers.
- Long cell values are visually truncated so descriptive text does not dominate narrow widget columns; the full text remains available through the native `title` tooltip.
- Aggregate KPI metadata renders the configured field label when available rather than exposing the raw database field name.
- No DTO is flattened and no runtime model/service wiring changed.

## Boundary

Builder/configuration remains array-based. Generated Dashboard runtime remains object-first (`DashboardData`, `DashboardWidget`, `Kpi`, `SeriesPoint`, `RecentRecord`) through the View.
