# Current baseline — myCrudCI4 2.9.1-dev24-fix11-fix35

This document summarizes the current consolidated project contracts. Historical DEV notes remain useful for chronology, but this file plus the canonical `docs/` pages describe the active baseline.

## Generated architecture

- schema facts come from the database; application choices come from Builder configuration;
- schema-known dependencies are generated explicitly at generation time;
- Standard/Full reads use concrete Models; writes use Services;
- Services contain no SQL/direct DB access;
- persistent custom business hooks live in create-only Service Extensions;
- `app/Generated/` is replaceable staging.

## Dashboard 2.0

- Builder/configuration structures are arrays;
- runtime composition uses typed DTO objects;
- `DashboardData -> DashboardWidget -> Kpi/SeriesPoint/RecentRecord` remains object-first through Controller and View;
- Recent widgets use concrete generated Models and relation-aware labels;
- aggregates use `DashboardQuery`;
- `php spark mycrud:test-dashboard` is the dedicated architecture/runtime smoke suite.

## Shield

- Web CRUD: `crudSecurity`, Shield `session`, optional explicit permissions;
- REST API: `apiSecurity`, Shield `tokens`, optional explicit permissions;
- the two settings are independent;
- no runtime security resolver.

## Builder UX

- intent-first flow: Architecture -> Relations/Form layout -> Fields -> Generate to staging;
- advanced API/MCP/security controls do not replace the core workflow;
- Parent database tables is sticky on desktop and follows the page scroll;
- no nested internal vertical scroller in Parent database tables.

## Acceptance

Run at minimum:

```bash
php spark mycrud:test-dashboard
php spark mycrud:test-all customer
php spark mycrud:test-all film
php spark mycrud:check-query-layer film
php spark mycrud:check-api film
```


## RC readiness gate (fix37)

Use `php spark mycrud:release-check <table> [table ...]` as the final release-candidate matrix. It composes existing diagnostics and tests; it does not publish operational files.
