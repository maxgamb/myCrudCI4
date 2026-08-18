# 2.9.1-dev24-fix11-fix35 — Documentation consolidation + Parent tables sticky-only UX

## Scope

This is a consolidation/UI fix. It does not change generated CRUD runtime architecture.

## Parent database tables

The main Builder keeps `Parent database tables` as a sticky desktop navigation card. The page is the only vertical scroll container: the previous `max-height` / `overflow-y:auto` list scroller introduced in fix31 is removed.

```text
Builder page scroll
    ↓
Parent database tables card follows (sticky)
    ↓
No nested table-list scrollbar
```

On smaller screens the card remains non-sticky as part of the responsive single-column flow.

## Documentation baseline

Canonical documentation now records the current contracts:

- generation-time explicit/static Model and Service wiring;
- `Model` reads / `Service` writes for Standard/Full;
- Dashboard 2.0 object-first DTO boundary through the View;
- Builder intent-first UX and staging-only generation;
- independent Shield security for Web CRUD (`crudSecurity`) and REST API (`apiSecurity`);
- local read-only MCP boundary;
- current test commands including `mycrud:test-dashboard`.

## Regression

`BuilderParentTablesStickyUxTest` verifies that the card remains sticky and that the removed nested-scroll markers do not return.
