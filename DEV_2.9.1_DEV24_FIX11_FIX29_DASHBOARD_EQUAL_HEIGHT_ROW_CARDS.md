# 2.9.1-dev24-fix11-fix29 — Dashboard equal-height row cards

This UI-only fix aligns all Dashboard panels in the same responsive Bootstrap row to the same height.

## Generated view contract

- widget row: `align-items-stretch`
- widget column: `d-flex dashboard-widget-column`
- widget card/link: `h-100 w-100 dashboard-widget-card`

The browser determines row height from the tallest widget in each wrapped row. No fixed global height is used, so the layout remains responsive.

Dashboard 2.0 object/DTO boundaries and static Model wiring are unchanged.
