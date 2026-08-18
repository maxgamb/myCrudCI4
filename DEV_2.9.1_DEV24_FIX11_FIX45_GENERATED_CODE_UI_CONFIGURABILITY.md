# 2.9.1-dev24-fix11-fix45 — Generated code & UI configurability

Pre-RC developer-experience consolidation.

## Contracts

- Generated PHP keeps behavior intact while trailing whitespace and excessive blank lines are normalized centrally by `GeneratorTrait`.
- Generated Views expose stable HTML comments for page/form/field/relation/action sections; these markers are documentation only.
- Builder field-width choices come from `Config\\MyCrud::$bootstrapFieldWidths`.
- `defaultBootstrapFieldWidth` is used only when no field width has been persisted yet.
- Generated relation-panel widths come from `Config\\MyCrud::$relationPanelWidths` and are resolved at generation time.
- Per-CRUD persistent configuration remains authoritative for the chosen field width.
- No runtime metadata resolver or dynamic relation dispatcher is introduced.
