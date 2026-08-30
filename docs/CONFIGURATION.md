# Configuration

## Global configuration

Global defaults are defined in:

```text
app/Config/MyCrud.php
```

They include generated paths, default architecture, pager/export behavior,
relation thresholds, upload rules, and test scaffolding options.

## Per-table configuration

Builder decisions are persisted in:

```text
app/MyCrudConfig/<table>.php
```

The database schema remains authoritative for technical schema information.
Persistent configuration stores application decisions such as presentation,
relations, API capabilities, security, MCP capabilities, and Form Sections.


## Builder navigation

The Builder uses one page scroll. The **Parent database tables** card is sticky on desktop so table navigation remains available while editing, but the table list itself does not create a nested scrollbar. On small screens the card returns to the normal document flow.

## Shield security

Shield is optional and Web CRUD security is independent from REST API security.

```text
crudSecurity
  auth: none | shield_session
  permissions: list/read/create/update/delete/trash/restore/force_delete

apiSecurity
  auth: none | shield_tokens
  permissions: list/read/create/update/delete/trash/restore/force_delete/upload
```

The generator emits explicit `session`, `tokens`, and `permission:<name>` filters. It does not resolve security policies dynamically at runtime.

## Form Sections

Create/Edit fields can be grouped into collapsible sections. Each section can define:

- title;
- description;
- open/closed state;
- order;
- Bootstrap width from 1 to 12.

The Bootstrap `col-*` class is applied to an outer wrapper so grid gutters create
real horizontal and vertical spacing between sections.

## Field visibility

REST API visibility and MCP visibility are independent configuration dimensions.
A field hidden from REST is not automatically hidden from MCP, and vice versa.


## Many-to-many related create

Pure many-to-many relations can optionally allow creation of one new target
record directly from the main Create/Edit form.

Builder option:

```text
Create new related record
```

Current scope is intentionally conservative:

- target must be a writable base table;
- target must have a single primary key;
- required target fields must be representable by standard form controls;
- nested foreign-key fields are not enabled in this first implementation;
- one new target record can be created per relation and form submission.

The transaction order is:

```text
BEGIN
→ validate main form and new related payload
→ create new many-to-many target record
→ create/update main record
→ validate selected target IDs
→ synchronize pivot rows
COMMIT
```

If any step fails, the transaction is rolled back.

The newly created target ID is automatically added to the many-to-many
selection before pivot synchronization.


### Availability diagnostics

The Builder reports availability directly beside the
`Create new related record` option. The status is shown once, without a separate
duplicate availability row.

For Sakila, both `actor` and `category` are valid simple targets.

If a target is unavailable, myCrudCI4 exposes the reason instead of silently
removing the option.


## Fields configuration reference

The **Fields** area of `/mycrud/builder/configure/<table>` combines database
metadata with developer choices.

The database remains authoritative for:

- physical column names;
- column types;
- primary keys;
- foreign keys;
- nullability;
- auto-increment;
- DB-managed timestamps/defaults.

The Builder controls application behavior.

| Setting | Effect |
|---|---|
| Input type | Generated Create/Edit HTML control |
| Label | User-facing caption only |
| Bootstrap width | Form grid width |
| Form section | Create/Edit grouping |
| Initial value | Create-only initial value |
| Searchable | Dynamic filter availability |
| Sortable | Server-side sort availability |
| Visible in list | Index column exposure |
| Visible in form | Create/Edit exposure |
| Visible in details | Detail/View exposure |
| API visible | REST field exposure |
| MCP visible | MCP field exposure |
| Exportable | CSV/Word exposure |
| Sensitive | Explicit restricted-field policy |
| required / readonly / disabled | Generated form and validation behavior |
| maxlength / min / max / step / pattern / placeholder | HTML/validation-compatible hints |

### Foreign-key fields

Foreign-key fields also expose relation-specific choices:

- **Full select / AJAX** controls option loading;
- **Display value** controls the readable label shown instead of the FK value;
- **Display template** can combine multiple parent columns;
- **Quick filter** enables relation-aware filtering/navigation;
- **Link to parent** exposes the related parent record;
- **Accept FK from URL** enables safe Create context after server-side validation;
- **New parent link** navigates to a separate parent Create;
- **Select or create new** creates the parent inline inside the main transaction.

The DB still stores only the foreign-key value.

Nullable empty foreign-key values are normalized from `''` to `NULL` before
persistence.

### Pure pivot tables

A pure pivot may appear in both relation sections:

1. **Child relations (hasMany)** — technical pivot-table panel.
2. **Many-to-many relations** — semantic target relationship.

These are not duplicate switches. They control different generated behavior.

Recommended default: leave the technical pivot hasMany disabled unless the
application needs to expose the pivot table itself.


## Dashboard Builder

The Dashboard Builder is available at:

```text
/mycrud/dashboard
```

It is intentionally built **on top of configured CRUDs** rather than as a
second independent data model.

### Reuse rule

For record-shaped widgets such as **Recent records**, the generated Dashboard reuses the already generated concrete CRUD Model. Source Entities/objects are normalized into `RecentRecord` DTOs; `DashboardData`, `DashboardWidget`, and record/series/KPI DTOs stay objects through Controller and View.

For aggregate values such as KPI totals, Dashboard-specific query code is kept
in:

```text
app/Libraries/Dashboard/DashboardQuery.php
```

and the result is normalized through small DTOs such as:

```text
App\DTO\Dashboard\Kpi
App\DTO\Dashboard\SeriesPoint
```

### Persistent configuration

```text
app/MyCrudConfig/Dashboards/main.php
```

### Generated files

```text
app/Generated/DTO/Dashboard/
app/Generated/Libraries/Dashboard/
app/Generated/Services/DashboardService.php
app/Generated/Controllers/DashboardController.php
app/Generated/Views/dashboard/
app/Generated/Routes/dashboard.php
```

### Foundation widgets

- **KPI Count** — aggregate count, returned as `Kpi`;
- **Recent records** — reuses the existing CRUD Model/Entity;
- **Quick link** — navigation to an existing CRUD.

The Dashboard-specific query layer must not duplicate normal CRUD record
retrieval. It is reserved for aggregates/statistics that do not naturally map
to one Entity.


### Analytics widgets

The Dashboard Builder now supports:

#### KPI Aggregate

```text
Source CRUD: payment
Operation: SUM
Numeric value field: amount
```

Supported operations:

```text
SUM
AVG
MIN
MAX
```

Only numeric schema fields are available as value fields.

#### Grouped chart

```text
Source CRUD: payment
Operation: SUM
Value field: amount
Group by: staff_id
Chart: bar
```

For a `COUNT` grouped chart no numeric value field is required.

Supported chart types:

```text
bar
line
doughnut
```

The generator resolves the current CRUD configuration again and rejects stale
or incompatible field selections. Dashboard SQL identifiers are therefore
never taken directly from arbitrary request input.

Grouped results are normalized to `SeriesPoint` DTO instances before they reach
the View.


### Widget presentation and filters

KPI widgets can configure:

- decimals from 0 to 4;
- a short prefix such as `€`;
- a short suffix such as `%`.

Formatting changes only the displayed string. `Kpi::value` remains numeric.

Each data widget can also define one optional filter:

```text
Field: release_year
Operator: >=
Value: 2005
```

Supported operators:

```text
eq
neq
gt
gte
lt
lte
contains
starts_with
```

The filter field must exist in the current configured CRUD. The generator
revalidates the field and drops invalid/stale filter definitions.

Recent-record widgets now use:

- fields marked `Visible in list` by the CRUD Builder;
- configured field labels;
- Entity property access when a generated Model returns Entity objects.

This keeps record presentation aligned with the CRUD instead of exposing raw
database names by default.


### Global date filter

Enable the global period control in the Dashboard Builder:

```text
Global date filter
Enabled: yes
Label: Period
```

Then map each widget to one compatible date field:

```text
Widget: Total payments
Global period mapping: payment_date

Widget: Rentals by staff
Global period mapping: rental_date
```

Only fields whose current CRUD schema type is `DATE`, `DATETIME`, or
`TIMESTAMP` are offered.

At runtime the generated Dashboard accepts:

```text
?from=YYYY-MM-DD&to=YYYY-MM-DD
```

Dates are validated server-side. If both are supplied in reverse order, the
generated Controller swaps them.

The global period combines with the widget-local filter configured for each widget.


### Compact Dashboard widget configuration

Dashboard widget cards are intentionally split into two levels.

#### Core configuration

Always visible:

```text
Type
Source CRUD
Widget title
Width
```

Type-specific primary controls remain visible only when relevant:

```text
KPI Aggregate -> Operation + Value field
Grouped Chart -> Operation + Value field + Group by + Chart
Recent records -> Limit
```

#### Advanced configuration

Collapsed by default unless already configured:

```text
Presentation
Global period
Local filter
```

This keeps large Dashboards manageable without removing any configuration
option. The card header shows a live summary of the current widget.


### Widget preview and Recent columns

Each Dashboard Builder card includes a lightweight live preview. It is a
structural preview, not a database query: it shows the expected KPI, chart,
table, or link shape while configuration changes.

For **Recent records**, the Builder exposes an ordered multi-selection:

```text
Recent columns
- select the fields to display
- Up / Down changes generated column order
```

Selections are validated again against the current CRUD schema during
generation. If no explicit valid selection exists, the generator falls back to
the CRUD fields configured as `Visible in list`.

### Date grouping

When a Grouped chart uses a DATE/DATETIME/TIMESTAMP field as `Group by`, the
Builder exposes:

```text
Exact value
Day
Month
Year
```

Date-group expressions are generated by `DashboardQuery`. MySQL/MariaDB,
PostgreSQL, and SQLite have explicit expressions; unsupported drivers safely
fall back to the raw field value.


### Generic global filters

The Dashboard Builder can define up to three global filters.

A filter definition contains:

```text
Enabled
Key
Label
Operator
Input type
```

Supported operators:

```text
eq
neq
gt
gte
lt
lte
contains
starts_with
```

Supported input types:

```text
text
number
```

Each widget has a **Global filter mappings** panel. A global filter is mapped
to a field from that widget's configured CRUD.

The generator validates:

- filter identifiers;
- supported operators;
- supported input types;
- per-widget mapped fields against the current CRUD schema.

At runtime the generated Dashboard accepts parameters using the `gf_` prefix,
for example:

```text
?gf_store=1
?gf_status=active
```

Multiple global filters are combined with the existing local widget filter and
global date period.


### N:N inline create and target foreign keys

`Create new related record` for a pure many-to-many pivot evaluates the
**final target table**, not the technical pivot table.

Target foreign keys do not automatically disable the feature.

Supported target FK:

```text
target FK
→ valid parent table/key
→ inline option mode = select
→ generated select control
→ server-side parent-row existence check
```

Still unavailable:

```text
target FK requires AJAX/nested handling not supported by the inline panel
target is a VIEW
target has unsupported required fields
target does not expose a compatible single primary key
```

This distinction allows cases such as Sakila `Category -> Film` through
`film_category`, where Film's Language foreign keys can be selected normally.


## Builder and generated form widths

Project-wide Bootstrap width policy lives in `app/Config/MyCrud.php`.

```php
public array $bootstrapFieldWidths = [
    12 => 'col-md-12',
    8  => 'col-md-8',
    6  => 'col-md-6',
    4  => 'col-md-4',
    3  => 'col-md-3',
];

public int $defaultBootstrapFieldWidth = 6;
```

`bootstrapFieldWidths` controls which values are offered by **Builder > Fields > Width Bootstrap**.
The selected numeric width remains part of the persistent CRUD configuration. This keeps the
project-wide policy separate from the layout chosen for one specific CRUD.

Generated relation UI widths are configured separately:

```php
public array $relationPanelWidths = [
    'manyToMany' => 12,
    'relatedCreateField' => 6,
    'manyToManyRelatedCreateField' => 6,
];

Related Create offcanvas panels use one project-wide pixel width:

```php
public int $relationOffcanvasWidth = 640;
```

This applies to both belongsTo and many-to-many Related Create panels. It does not change the Bootstrap grid width of relation cards in the main form. Generated markup uses the configured pixel width with a `100vw` safety cap for small screens.
```

Values are Bootstrap grid units from `1` to `12` and are evaluated at generation time. They do
not introduce runtime relation metadata or dynamic resolvers.

## Generated View structure markers

Generated Views include stable HTML comments such as:

```html
<!-- mycrud:start fields -->
<!-- mycrud:end fields -->
<!-- mycrud:start relation-panels -->
<!-- mycrud:end relation-panels -->
<!-- mycrud:start form-actions -->
<!-- mycrud:end form-actions -->
```

These comments are developer navigation markers only. Runtime behavior does not depend on them.


## Many-to-many form width
Each many-to-many relation can persist its own `formWidth` from Builder. The project-level `relationPanelWidths['manyToMany']` value is only the default. In generated Create/Edit forms the Search and New-related actions are rendered as one attached input group inside that configured width.
