# 2.9.1-dev24-fix11-fix30 — Builder configuration status UX

This fix improves the general CRUD Builder only. It does not change Dashboard 2.0, DTOs, Models, Services, API contracts, or generated CRUD behavior.

## Goal

Make a long Builder configuration page easier to scan by showing the current state directly in the sticky navigation.

## UI contract

- Architecture shows the current Basic / Standard / Full selection.
- Relations shows On / Off.
- Form Sections shows the configured section count.
- Fields shows the schema field count.
- API shows Full only when Full architecture is selected; otherwise Off.
- MCP shows On only when enabled under Full architecture.
- Status badges update immediately as the form changes.

The Builder remains intent-first and generation still writes only to `app/Generated/`.
