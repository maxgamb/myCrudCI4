# myCrudCI4 2.9.1-dev12 — Dashboard Global Filters

Baseline: `2.9.1-dev11`.

## Dashboard-level filters

Up to three global filters can be configured.

Each filter has:

- Enabled
- Key
- Label
- Operator
- Input type

Runtime parameters use the `gf_` prefix.

Example:

```text
gf_store=1
```

## Widget mapping

Each widget maps a global filter key to one current CRUD field.

The same Dashboard-level filter can therefore target different physical fields
across widgets.

## Safety

Generation validates:

- filter IDs;
- operator whitelist;
- input type whitelist;
- mapped widget fields against current CRUD schema.

Unknown runtime `gf_*` parameters are ignored by the generated Service unless a
validated widget mapping exists.

## Composition

Global filters combine with:

- local widget filter;
- global date range;
- grouped statistics;
- Recent-record Model reuse.
