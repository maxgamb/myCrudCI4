# myCrudCI4 2.9.1-dev24-fix11-fix24 — Dashboard Recent relation labels + width guidance

This fix keeps the Dashboard 2.0 object boundary unchanged and improves Recent-record usability.

- Recent widgets detect selected `belongsTo` fields at generation-time.
- The generated `DashboardService` calls the concrete Model's explicit `find<Field>Option()` method for those FK values. No runtime relation/table resolver is introduced.
- Relation values are cached per widget/request to avoid repeated lookups for the same FK id.
- Recent column headers use human relation labels (for example `Language` instead of `Language Id`).
- Dashboard Builder shows a width recommendation based on the number of selected Recent columns: 3→6, 4–5→8, 6→12. The choice remains under developer control; width is not silently changed.
- DTOs remain objects through the Controller/View boundary.
