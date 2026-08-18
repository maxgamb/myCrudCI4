# myCrudCI4 2.9.1-dev24-fix11-fix25 — Dashboard semantic titles + chart guidance

This refinement improves Dashboard Builder semantics without changing the frozen Dashboard 2.0 runtime architecture.

## Changes

- Automatic titles are generated from widget intent and configured field labels.
- Builder field selectors show human/configured labels while preserving database identifiers as values.
- Grouped charts receive static configuration guidance for primary-key grouping, relation fields, exact date grouping, and filters that target the same grouped field.
- No runtime metadata resolver was introduced; generated Dashboard Model wiring remains explicit.
