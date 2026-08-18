# myCrudCI4 2.9.1-dev4 — Builder UX & Fields Guidance

Baseline: `2.9.1-dev3-CONSO`.

This release improves Builder clarity without changing CRUD persistence logic.

## Relation configuration

Pure pivots are intentionally available in two layers:

- **Technical pivot hasMany** — optional direct view of the pivot table.
- **Semantic many-to-many** — selection, synchronization, inline related create,
  and target-record behavior.

The Builder now labels the technical pivot explicitly and recommends leaving it
disabled unless the pivot table itself needs to be exposed.

## Fields configuration

A detailed guide is displayed directly above the field cards. It explains:

- Input type;
- Label;
- Bootstrap width;
- Form section;
- Initial Create value;
- Searchable / Sortable;
- list/form/detail visibility;
- API / MCP visibility;
- Exportable / Sensitive;
- boolean and value attributes;
- foreign-key loading, display, navigation, context, and inline parent creation;
- DB-managed fields and nullable FK normalization.

The main principle is explicit:

> The database defines schema truth. The Builder defines application behavior.
