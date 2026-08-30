# Domain Analyzer

`Tools > Domain Analyzer` is a read-only structural analyzer for the current database schema.

Its purpose is to build a **resource map** that can support architectural reasoning and later AI-assisted business-logic analysis. It does not generate CRUDs, modify configuration, or invent application use-cases.

## V2: two-stage reasoning

V2 separates two different questions:

1. **What structural shape does this database object have?**
2. **What domain role is that shape compatible with?**

This avoids the simplistic rule `many foreign keys = transactional resource`.

The analyzer now considers:

- primary keys and composite primary keys;
- generated versus non-generated primary keys;
- outgoing and incoming foreign keys;
- FK delete/update rules;
- relation direction;
- table/view type;
- compact table shape;
- autonomous/non-structural columns;
- true lifecycle/event fields;
- dependency strength;
- structural autonomy;
- structural root candidacy.

## Lifecycle fields

A lifecycle field must describe state or event timing.

Examples that count:

```text
rental_date
return_date
payment_date
closed_at
cancelled_at
status
state
```

Columns such as these do **not** count merely because they contain a domain word:

```text
rental_rate
rental_duration
replacement_cost
```

This distinction is important for catalog/master tables such as `film`.

## Classifications

Each database object is proposed as one of:

- **Master resource** — autonomous descriptive/business resource referenced elsewhere;
- **Transactional resource** — event/process resource combining parent relations with lifecycle/event state;
- **Dependent resource** — resource whose meaning is structurally dominated by one or more parents;
- **Lookup / reference** — compact dictionary/reference data, normally with no more than one parent dependency;
- **Pivot / relation** — key-dominated relation table between multiple parents;
- **SQL view** — read-oriented SQL view, kept separate from writable resources.

These are structural hypotheses, not domain truth. Every result exposes evidence and a confidence level.

## Structural autonomy and root candidates

V2 explicitly separates:

```text
graph centrality
!=
domain root candidacy
```

A table may be heavily referenced without being a good domain root.

Root candidacy now rewards:

- autonomous payload;
- own generated identity;
- children;
- lifecycle state;
- master/transactional role.

It penalizes excessive parent dependency.

Lookup, pivot, dependent and view objects are never promoted as structural roots.

A structural root is still **not** automatically the primary resource of a business operation.

## Important limitations

The analyzer intentionally avoids table-specific exceptions such as:

```php
if ($table === 'film') { ... }
```

All classifications must come from reusable structural rules.

Some schemas may omit useful foreign keys. In those cases the analyzer can only report a lower-confidence structural hypothesis. A small table with a non-generated primary key, no declared graph relations and a small payload may be treated as a satellite/dependent candidate.

## Business-logic boundary

The Domain Analyzer follows this rule:

> Never invent a business operation from the database schema alone.

A later AI-assisted step may combine:

```text
user requirement
+ Domain Analyzer resource map
+ generated Model / Service / Entity context
→ proposed business operation
→ developer confirmation
→ implementation
```

The database supplies the resource map; the application requirement supplies the use-case meaning.

## Development Guidance preview

The resource cards also translate the structural analysis into development guidance for a programmer working without AI.
The guidance combines **Structural Role + Structural Root + relations + lifecycle fields** and suggests the responsibility of Entity, Service, Model and Controller.

The nested **Commented code examples** preview shows schema-aware but business-neutral PHP examples adapted to `master`, `transactional`, `dependent`, `lookup`, `pivot` and `view` resources. For root-capable roles, the preview also branches on **Potential structural root YES/NO**: a root candidate may be shown as a possible use-case entry point and coordinator of related Services, while a non-root example is deliberately kept local. When available, examples use real table names, FK columns, parent/child relations, related Service names, meaningful fields and lifecycle fields. They remain fully commented guidance and do not define required MyCrud APIs or infer business semantics from those names.

This phase is intentionally read-only: it does not insert markers, placeholders or business methods into generated PHP files. Domain Analyzer continues to describe *how* a programmer could extend the generated architecture without claiming to know *which* business operation the application needs.

A Structural Root remains a structural candidate, not a DDD Aggregate Root and not an automatic business-use-case owner. `rootScore` is evidence for the preview, not authorization to invent orchestration.
