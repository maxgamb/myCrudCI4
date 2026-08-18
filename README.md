
> **Current release candidate:** `2.9.1-RC1`. Feature set is frozen; see `RELEASE_2.9.1_RC1.md`.
> Current development baseline: **myCrudCI4 2.9.1-dev24-fix11-fix35 — Documentation consolidation + Parent tables sticky-only UX**

# myCrudCI4

**Current version: 2.9.1-dev24-fix11-fix35 (Documentation consolidation + Parent tables sticky-only UX)**

myCrudCI4 is a database-driven CRUD generator for CodeIgniter 4.

It inspects the database schema, stores application-level decisions in persistent
per-table configuration, generates code in a safe staging area, and provides
review, publishing, diagnostics, API/OpenAPI, generated tests, and local read-only MCP support.

## Recommended workflow

```text
Database schema
    ↓
Builder
    ↓
app/MyCrudConfig/<table>.php
    ↓
Quick / CLI
    ↓
app/Generated/
    ↓
Diff / Review
    ↓
Publish
    ↓
app/ + tests/
    ↓
Generated tests
```

**Builder decides what to generate. Quick and CLI execute the saved configuration.**

## Architectures

- **Basic** — Model, Controller, Validation, Views, Routes.
- **Standard** — Basic + Entity + Service + persistent Service Extension Points.
- **Full** — Standard + REST API v1 + API Resource + API Validation + OpenAPI,
  optional CodeIgniter Shield integration, and local read-only MCP.

## Safe staging

Generated application code is written to:

```text
app/Generated/
```

Review it before publishing:

```bash
php spark mycrud:generate film --force
php spark mycrud:diff film
php spark mycrud:publish film --dry-run
php spark mycrud:publish film
php spark mycrud:test-generated film
```

## Builder

The Builder is the single design/configuration point for:

- architecture;
- fields and labels;
- Bootstrap column widths;
- Form Sections;
- filters and sorting;
- belongsTo, hasMany, and many-to-many relations;
- optional inline **Create new related record** for simple many-to-many targets;
- uploads;
- API capabilities;
- Web CRUD and REST API Shield security;
- MCP capabilities and MCP field visibility.

The database schema remains authoritative for technical facts such as column
types, primary keys, foreign keys, indexes, nullability, and database-managed timestamps.


### Builder navigation UX (fix34)

The main Builder keeps **Parent database tables** as a sticky navigation card on desktop.
The card follows page scrolling but does **not** create its own internal scroll area; the page remains the single scroll container.
This keeps long database lists predictable and avoids nested scrolling.

Shield security is exposed as two independent settings: Web CRUD uses `crudSecurity` (session + optional permissions), while REST API uses `apiSecurity` (Bearer tokens + optional permissions).

## API and OpenAPI

Full architecture can generate:

- REST API v1;
- list/read/create/update/delete capabilities;
- soft-delete trash/restore/force-delete capabilities when applicable;
- multipart file/image upload;
- stable OpenAPI operation IDs;
- optional Bearer-token protection with CodeIgniter Shield.

## MCP

MCP support in the 2.9 line is deliberately:

- local;
- STDIO-based;
- read-only;
- Service-layer based;
- independent from REST/Shield authentication.

Typical generated tools:

```text
list_film
get_film
get_film_language_id
list_film_inventory_by_film_id
```

Run diagnostics and the local server with:

```bash
php spark mycrud:mcp-doctor film
php spark mycrud:mcp-serve film --no-header
```

`--no-header` keeps STDOUT clean for the MCP JSON-RPC protocol.

## Tests and diagnostics

The canonical and complete Spark command inventory is `docs/CLI.md` (19 commands in this baseline).


```bash
php spark mycrud:test film
php spark mycrud:test-all film
php spark mycrud:test-generated film
php spark mycrud:doctor film
php spark mycrud:benchmark film
php spark mycrud:explain film
php spark mycrud:check-api film
php spark mycrud:check-query-layer film
```

Generated Full CRUDs can include Structure, Validation, API Resource, OpenAPI,
Shield Security, MCP Foundation, and MCP Resource Security contract tests.

## Technical documentation language

Starting with **2.9.1-dev2**, framework technical documentation is English-first:

- README and `docs/`;
- generated PHPDoc;
- MCP technical descriptions;
- developer-facing examples and release notes.

Application-facing labels and validation/UI messages remain localizable through
CodeIgniter language files and Builder configuration.

## Documentation

See:

- `docs/WORKFLOW.md`
- `docs/CLI.md`
- `docs/CONFIGURATION.md`
- `docs/API_OPENAPI.md`
- `docs/TESTS.md`
- `docs/MCP.md`
- `docs/ROADMAP.md`
- `CONTRIBUTING.md`
- `docs/development/ARCHITECTURE.md`
- `docs/development/ARCHITECTURE_RULES.md`
- `docs/development/ADDING_A_FEATURE.md`
- `docs/development/FEATURE_MATRIX.md`

The same operational documentation is available inside the application at `/mycrud/docs`.


## Language policy

The myCrudCI4 framework is English-first.

English is used for:

- source comments and PHPDoc;
- Builder and developer tools;
- CLI output and diagnostics;
- generated technical comments;
- tests, API/OpenAPI, and MCP descriptions;
- project documentation.

`app/Language/it/` is intentionally retained as an optional application
localization pack. It is not the framework's technical language.


### 2.9.1 consolidation

The current consolidation candidate includes regression coverage for:

- nullable foreign-key normalization (`''` → `NULL`);
- many-to-many `Create new related record`;
- persistent M:N related-create configuration;
- generated validation and transaction plumbing.

No new feature is introduced by the consolidation step.


### Builder Fields guidance

`/mycrud/builder/configure/<table>` now documents field-level behavior directly
in the UI, including form layout, visibility, filters/sorting, API/MCP exposure,
validation attributes, foreign-key navigation, and the distinction between
technical pivot hasMany and semantic many-to-many relations.


## Application Dashboard

myCrudCI4 includes a first Dashboard Builder foundation at:

```text
/mycrud/dashboard
```

The Dashboard follows a hybrid architecture:

```text
record-shaped data
→ reuse generated CRUD Model
→ reuse Entity when configured

aggregate/statistical data
→ DashboardQuery
→ small Dashboard DTO
```

The first widget set is intentionally small:

- KPI Count;
- Recent records;
- Quick link.

Dashboard configuration is stored separately from CRUD configuration:

```text
app/MyCrudConfig/Dashboards/main.php
```

Generated Dashboard files are staged under `app/Generated/` and can then be
published safely to the application tree.

Charts, SUM/AVG/grouped statistics, and filterable dashboard series are planned
as the next layer after this foundation is validated.


### Dashboard analytics

The Dashboard Builder supports the first analytics layer:

- KPI Count;
- KPI `SUM`, `AVG`, `MIN`, `MAX`;
- grouped statistics;
- bar, line, and doughnut charts;
- Recent records;
- Quick links.

Numeric operations are selectable only for numeric fields resolved from the
current CRUD schema. The generator validates all selected fields again before
writing Dashboard code.

Architecture:

```text
record data
→ existing CRUD Model / Entity

aggregate data
→ DashboardQuery
→ Kpi / SeriesPoint DTO
→ DashboardService
→ generated Dashboard View
```

Chart rendering uses Chart.js in the generated Dashboard View. SQL aggregation
remains server-side in `DashboardQuery`.


### Dashboard presentation and filters

Dashboard widgets now support a presentation layer on top of the analytics
foundation:

- compact KPI cards;
- configurable KPI decimals, prefix, and suffix;
- one optional safe filter per widget;
- Recent records use configured CRUD labels and visible Index fields;
- Recent records prefer Entity property access so configured casts/accessors can
  participate in presentation;
- chart group labels use CRUD field labels where available.

Supported filter operators:

```text
=
!=
>
>=
<
<=
contains
starts with
```

Filter fields are derived from the configured CRUD and revalidated by the
Dashboard generator before code is written.


### Dashboard global date filter

The Dashboard can expose one global `From / To` period selector.

Each widget maps that global period to one DATE/DATETIME/TIMESTAMP field from
its own CRUD. This allows the same period to filter different source tables
without forcing them to share the same column name.

Example:

```text
Global period: 2026-08-01 → 2026-08-31

Payment KPI  -> payment.payment_date
Rental chart -> rental.rental_date
Customer list -> customer.create_date
```

The generated Controller validates `YYYY-MM-DD` input before passing it to the
Dashboard Service. Each widget mapping is revalidated against the current CRUD
schema during generation.


### Dashboard Builder UI consolidation

The Dashboard Builder now uses compact widget cards.

Core widget configuration stays visible:

- type;
- source CRUD;
- title;
- width;
- operation/value/group/chart when required.

Secondary options are grouped into collapsible panels:

- Presentation;
- Global period;
- Local filter.

Each card header summarizes the widget type, source, title, and main operation.
Drag-and-drop has a dedicated grip handle and clearer visual feedback.


### Dashboard 3-column grid

The Dashboard Builder uses a responsive widget grid:

```text
desktop -> 3 cards per row
tablet  -> 2 cards per row
mobile  -> 1 card per row
```

Each card keeps the core widget controls visible and advanced options collapsed.


### Dashboard Builder productivity

Dashboard Builder adds three workflow improvements:

- live structural preview for each widget before generation;
- explicit Recent-record column selection and ordering;
- date grouping for grouped charts by exact value, day, month, or year.

Recent-record column order is persisted with the Dashboard configuration.
Date grouping is available only when the selected group field is a current
DATE/DATETIME/TIMESTAMP field.


### Dashboard global filters

The Dashboard Builder supports up to three generic Dashboard-wide filters in
addition to the global date range.

Each global filter defines:

- key;
- label;
- operator;
- input type (`text` or `number`).

Each widget can map the same global filter to a different field in its own CRUD.

Example:

```text
Global filter
key: store
label: Store
operator: =

Payment widget -> store_id
Rental widget  -> store_id
Customer widget -> store_id
```

At runtime the generated Dashboard uses query parameters such as
`?gf_store=1`. Unknown or unmapped filters are ignored.


### Many-to-many related-create with target foreign keys

Inline creation of a many-to-many target no longer becomes unavailable merely
because the target table contains foreign keys.

A nested target FK is supported when it can be represented safely as a normal
generated select.

Example:

```text
Category
  -> film_category
      -> Film
          -> language_id -> Language
```

Creating a new Film from the Category N:N panel can therefore expose
`language_id` and `original_language_id` as generated selects.

The feature remains unavailable when a nested FK requires unsupported inline
handling, for example an AJAX-only nested relation. Nested FK values are
revalidated server-side before the related target INSERT.

## Project generation workflow

Recommended baseline flow:

```bash
php spark mycrud:generate-all --force
php spark mycrud:publish-all
```

Then customize individual tables in Builder and regenerate/publish only the affected CRUD when needed. Standard/Full generated Services statically call related Services for related writes; related Services validate their own resource using the generated Rules class.


### Generated read/write ownership

From 2.9.1-dev24, Standard/Full generated code follows a strict simple split: reads go directly to Models; writes go through Services. Services no longer contain one-line read pass-through wrappers. Cross-resource writes use explicit generated Service calls, while parent/child/FK reads use explicit generated Model calls. Basic remains Model-only.

From 2.9.1-dev24-fix1, Service code is also feature-aware: unused relation/M2M parameters, transaction branches, normalization constants, and schema-specific preparation blocks are not generated. Normal Create, Update, and Related Create are all validated by the resource Service using its own generated Rules.

## dev24 frozen architecture baseline

From `2.9.1-dev24-fix11-fix15`, the dev24 architecture is frozen around explicit generated dependencies: related Models and Services are named directly in generated PHP, while `BaseCrudModel` contains only reusable owned-table infrastructure. `mycrud:test-all` includes an architecture boundary guard that rejects dynamic relation resolvers, SQL in Services/API controllers, and input/query policy leaking into API/MCP Resources. See `BASELINE_2.9.1_DEV24_FIX11_FIX15.md`.


## Safe developer customizations (fix11-fix16)

For Standard/Full CRUDs, persistent business customizations belong in `app/Services/Extensions/<Entity>ServiceExtension.php`. The file is create-only and is never overwritten by regeneration. New ServiceExtension files include a disabled/commented `exampleApplyBusinessRule()` helper showing the intended pattern: adapt the helper to real fields and call it explicitly from a `before*`/`after*` hook only when needed.

Do not use the example as a reason to put SQL in the ServiceExtension. Queries stay in the concrete Model. Cross-resource writes must call a concrete generated Service explicitly; do not introduce dynamic Model/Service/table resolvers. `app/Generated/` remains staging and must not be used for persistent manual customizations.

`php spark mycrud:ai-context [table]` now documents this customization workflow together with the frozen dev24 boundaries: `BaseCrudModel` shared infrastructure, explicit/static relation wiring, REST READ/WRITE separation, output-only API/MCP Resources, PATCH/upload Service methods, and the persistent ServiceExtension path.


### Dashboard 2.0 architecture (fix18)

Dashboard 2.0 is frozen around an object-first runtime boundary: Builder/configuration remains array-based, while generated runtime data uses `DashboardData`, `DashboardWidget`, `Kpi`, `SeriesPoint`, and `RecentRecord` objects through Controller and View. Recent widgets use generation-time concrete Models and relation-aware labels; aggregate widgets use `DashboardQuery`. `php spark mycrud:test-dashboard` protects these boundaries. See `BASELINE_DASHBOARD_2.0_DEV24_FIX11_FIX26.md`.
php spark mycrud:release-check film customer staff store rental

### Generated MCP publish synchronization

`mycrud:publish` treats generated PHPUnit contracts and `Mcp/` runtime artifacts as generator-owned outputs. They are synchronized from `app/Generated/` even in SAFE mode; stale table-owned MCP tools/manifests/resources are removed when capabilities are disabled. Other application files retain the normal SAFE/`--force` behavior.



### Developer-friendly generated UI

`app/Config/MyCrud.php` is the project-wide source for the Bootstrap widths offered by the Builder
and for generated relation-panel widths. The individual CRUD still persists its selected field
widths. Generated Views also contain stable `<!-- mycrud:start ... -->` / `<!-- mycrud:end ... -->`
markers to make safe developer customization and code review easier.


### Builder many-to-many width

Many-to-many relation widths selected in the Builder are persisted as `formWidth` per relation and reused on regeneration.
