# myCrudCI4 2.9.1-dev24-fix11-fix28 — Builder intent-first UX consolidation

This fix changes only the general Builder presentation and guidance. It does not change generated CRUD runtime boundaries, Dashboard 2.0, Model ownership, Service ownership, relation wiring, API contracts, or database behavior.

## UX contract

The Builder should expose application intent before technical implementation details:

1. Architecture
2. Relations and form layout
3. Fields
4. Save / generation to staging

API and MCP remain available but are explicitly presented as Advanced configuration. Their forms are collapsed by default and still submit exactly the same configuration when unchanged.

Generation remains staging-safe: the Builder writes to `app/Generated/`. The overwrite option is an advanced staging concern and is no longer a primary action.

## Regression guard

`BuilderIntentFirstUxTest` checks the visible workflow labels, advanced grouping, staging wording, and collapsed field guidance.
