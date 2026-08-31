# myCrudCI4

> **Current stable release:** `2.9.3`
> **Stable tag:** `v2.9.3`

myCrudCI4 is a **database-driven application scaffolding system for CodeIgniter 4**.

It inspects an existing database schema, stores developer decisions in persistent per-table configuration, and generates explicit CI4 application code for CRUD, relations, validation, APIs, tests, dashboards, and development tooling.

The generator is deterministic and works without AI. Its generated code and project context are also designed to be easy for AI-assisted development tools to understand.

---

## Why myCrudCI4

myCrudCI4 is intended for data-centric applications such as:

- management systems;
- back-office applications;
- ERP / CRM / PMS-style projects;
- internal administration tools;
- legacy database modernization;
- applications with many related tables.

The goal is not only to save CRUD boilerplate.

The main goal is to turn a database schema into a **consistent, explicit and testable CodeIgniter 4 application structure**.

```text
Database schema
      │
      ├── columns / PK / FK / indexes
      ├── belongsTo / hasMany / many-to-many
      └── SQL VIEW awareness
      │
      ▼
   myCrudCI4
      │
      ├── Builder / persistent config
      ├── architecture selection
      ├── relation analysis
      ├── Domain Analyzer
      └── schema-aware guidance
      │
      ▼
Generated CI4 application code
```

myCrudCI4 intentionally generates **explicit PHP classes and static dependencies** rather than requiring a dynamic runtime resolver.

---

# Current architecture

myCrudCI4 supports three main CRUD architectures.

| Architecture | Generated application structure | Intended use |
|---|---|---|
| **Basic** | Model + Controller + Validation + Views + Routes | Simple web CRUD |
| **Standard** | Basic + Entity + Service + persistent Service Extension | Structured application CRUD |
| **Full** | Standard + REST API v1 + API Resource + API Validation + OpenAPI | Web + API applications |

Core ownership rules:

```text
Basic
Controller
   ↓
Model
   ↓
Database
```

```text
Standard / Full — READ
Controller
   ↓
Model
   ↓
Database
```

```text
Standard / Full — WRITE
Controller
   ↓
Service
   ↓
Entity / Model
   ↓
Database
```

```text
Full API — READ
API Controller
   ↓
Model
   ↓
API Resource
   ↓
JSON
```

```text
Full API — WRITE
API Controller
   ↓
Service
   ↓
Model
```

Cross-resource writes use **explicit generated Services**.
Relation reads use **explicit generated Models**.

SQL remains in the Model/query layer.

---

# Domain Analyzer

Version 2.9.2 includes a database-driven **Domain Analyzer**.

The analyzer does not invent business logic. It uses structural evidence from the database to help the developer understand how a resource may fit into the application.

It can classify resources as:

- **Master**
- **Transactional**
- **Dependent**
- **Lookup**
- **Pivot**

It also identifies **Potential Structural Roots**.

A structural root is only a development signal. It is **not automatically a DDD Aggregate Root** and it does not authorize myCrudCI4 to invent cross-resource business behavior.

```text
Database structure
      ↓
Structural role
      +
Potential Structural Root
      +
Parents / Children
      +
Lifecycle signals
      ↓
Developer guidance
```

The application requirement remains authoritative.

---

## Schema-aware, business-neutral guidance

Generated Model, Entity, Service and Controller classes can include commented development guidance derived from the real schema.

Full resources also receive compact API boundary guidance in their generated Resource API Controllers.

Example:

```php
// ========================================================================
// MYCRUD DOMAIN DEVELOPMENT EXAMPLE
// ========================================================================
// Resource: film
// Structural role: MASTER
// Structural root: YES
//
// FK OUT: film.language_id -> language.language_id | LanguageService
// FK IN : inventory.film_id -> film.film_id | InventoryService
```

A Model may then contain a commented example based on a real FK:

```php
/*
 * Example: real FK-scoped query.
 * Relation: film.language_id -> language.language_id
 *
 * public function findByLanguageId(int|string $languageId): array
 * {
 *     return $this
 *         ->where('language_id', $languageId)
 *         ->findAll();
 * }
 *
 * Add this method only when required by the application.
 */
```

The guidance uses real table names, FK columns, parents, children and generated class names.

It deliberately does **not** invent fields such as:

```text
left_id
right_id
business_field
some_field
context_id
```

and does not infer application operations such as `approveOrder()` or `closeBooking()` from the database alone.

### Lifecycle safety

Temporal fields such as:

```text
payment_date
rental_date
return_date
```

may be reported as lifecycle-related signals, but they are **not automatically treated as state fields**.

Transition examples are reserved for explicit state-like fields such as:

```text
status
state
stato
stage
phase
workflow_state
```

This keeps Domain guidance structural rather than speculative.

---

# Relations

myCrudCI4 can scaffold:

- `belongsTo`;
- `hasMany`;
- many-to-many relations through pivot tables;
- relation-aware labels and navigation;
- Related Create;
- optional inline creation of related records where the generated relation is safe;
- nested foreign-key selects when they can be represented deterministically.

Generated relation dependencies are explicit and generation-time resolved.

The architecture avoids generic runtime table/model/service dispatchers.

---

# SQL VIEW resources

Database views are detected as **read-only resources**.

A SQL VIEW can generate the read side of the application, but it does not receive a writable Service contract.

Typical SQL VIEW behavior:

```text
Model       ✓
Entity      ✓ when architecture requires it
Controller  ✓
Views       ✓
API GET     ✓ in Full architecture

Service write boundary  ✗
Create / Update / Delete ✗
```

The release regression matrix protects this distinction.

---

# Installation and Quick Start

## 1. Clone the stable release

```bash
git clone --branch v2.9.3 --depth 1 https://github.com/maxgamb/myCrudCI4.git myCrudCI4
cd myCrudCI4
```

Install dependencies:

```bash
composer install
```

---

## 2. Configure the database

Create or edit `.env`:

```ini
database.default.hostname = localhost
database.default.database = database_name
database.default.username = database_user
database.default.password = database_password
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306
```

For development:

```ini
CI_ENVIRONMENT = development
```

---

## 3. Start CodeIgniter

```bash
php spark serve
```

Default development URL:

```text
http://localhost:8080
```

Open myCrudCI4:

```text
http://localhost:8080/index.php/mycrud
```

---

## 4. Create initial CRUD configurations

Quick Global:

```text
http://localhost:8080/index.php/mycrud/quick
```

Persistent CRUD configuration is stored under:

```text
app/MyCrudConfig/
```

The database remains authoritative for physical schema information.

Configuration stores **developer decisions**, not a frozen copy of the database schema.

---

## 5. Configure resources with Builder

Builder:

```text
http://localhost:8080/index.php/mycrud/builder
```

Builder controls application scaffolding such as:

- Basic / Standard / Full architecture;
- fields and labels;
- validation;
- form input types;
- Bootstrap layout widths;
- Form Sections;
- filters and sorting;
- exports;
- file/image uploads;
- belongsTo / hasMany / many-to-many;
- Related Create;
- API capabilities;
- optional Shield protection;
- MCP capabilities;
- generated relation UI.

**Builder decides what to generate. Quick and CLI execute the saved configuration.**

---

## 6. Generate

Generate all configured resources:

```bash
php spark mycrud:generate-all --force
```

Generate one resource:

```bash
php spark mycrud:generate table_name --force
```

Generated code is written to:

```text
app/Generated/
```

`app/Generated/` is a **regenerable staging area**, not the permanent location for developer customizations.

---

## 7. Review and publish

Recommended single-resource workflow:

```bash
php spark mycrud:generate film --force
php spark mycrud:diff film
php spark mycrud:publish film --dry-run
php spark mycrud:publish film
php spark mycrud:test-generated film
```

All configured resources:

```bash
php spark mycrud:generate-all --force
php spark mycrud:publish-all --dry-run
php spark mycrud:publish-all
```

Published files become part of the operational application.

---

# Safe customization

The generator separates regenerable staging from developer-owned application logic.

```text
app/Generated/
    → regenerable staging

app/MyCrudConfig/
    → persistent scaffolding decisions

app/Services/Extensions/
    → persistent developer-owned Service customizations

published app/
    → operational application code
```

For writable Standard/Full resources, use the persistent Service Extension point for application-specific write behavior.

General rules:

- record-local representation/casts/accessors may live in the Entity;
- SQL and query composition stay in the concrete Model;
- transactions and cross-resource writes belong in Services;
- cross-resource writes call concrete related Services explicitly;
- do not place business rules in Controllers or API Controllers;
- do not put persistent manual customizations inside `app/Generated/`.

The commented Domain examples are guidance only. They are not required APIs.

---

# API and OpenAPI

Full architecture can generate:

- REST API v1;
- capability-aware list/read/create/update/delete operations;
- API validation;
- API Resources;
- OpenAPI definitions;
- multipart file/image upload;
- soft-delete operations where supported;
- optional Bearer-token security through CodeIgniter Shield.

Generated Resource API Controllers receive compact boundary guidance.

Example responsibility:

```text
HTTP parsing / status / serialization
        ↓
API Controller

READ  → Model
WRITE → Service
```

SQL and business orchestration do not belong in the API Controller.

---

# MCP

MCP support is designed as a local development/integration surface.

Current architectural principles:

- local STDIO transport;
- resource-aware generated tools;
- read-oriented access;
- output through dedicated MCP Resources;
- no SQL inside MCP Resources.

Examples:

```text
list_film
get_film
get_film_language_id
list_film_inventory_by_film_id
```

Useful commands:

```bash
php spark mycrud:mcp-doctor film
php spark mycrud:mcp-serve film --no-header
```

`--no-header` keeps STDOUT clean for the JSON-RPC protocol.

---

# Dashboard Builder

myCrudCI4 includes project-level Dashboard generation.

Dashboard code intentionally has a different role from table/resource Domain guidance.

Architecture:

```text
record-shaped data
    → generated CRUD Model / Entity

aggregate data
    → DashboardQuery
    → Dashboard DTOs
    → DashboardService
    → DashboardController
    → View
```

Supported concepts include:

- KPI Count;
- `SUM`, `AVG`, `MIN`, `MAX`;
- grouped statistics;
- bar / line / doughnut charts;
- Recent records;
- Quick links;
- global date range;
- optional global/local filters;
- configurable KPI formatting;
- responsive widget grid.

Dashboard Controller and Dashboard Service are **project-level generated artifacts** and are intentionally outside the table-specific Domain guidance contract.

---

# Tests, diagnostics and release gates

myCrudCI4 includes generated contracts and architecture regression checks.

Useful commands:

```bash
php spark mycrud:test film
php spark mycrud:test-all film
php spark mycrud:test-generated film

php spark mycrud:doctor
php spark mycrud:benchmark film
php spark mycrud:explain film

php spark mycrud:check-api film
php spark mycrud:check-query-layer film

php spark mycrud:test-dashboard
php spark mycrud:release-check film customer staff store rental
```

The regression system protects, among other things:

- generated structure;
- validation contracts;
- relation contracts;
- many-to-many behavior;
- REST/API architecture;
- OpenAPI;
- MCP contracts;
- SQL VIEW read-only behavior;
- Dashboard boundaries;
- explicit Model/Service ownership;
- schema-aware Domain guidance.

---

# AI-assisted development

AI is **optional**.

myCrudCI4 itself remains deterministic and database-driven.

The project can generate context that helps an AI understand:

- the CodeIgniter architecture;
- configured CRUD resources;
- relations;
- layer responsibilities;
- safe customization rules;
- generated application conventions.

Generate AI context with:

```bash
php spark mycrud:ai-context
```

or for a specific resource where supported:

```bash
php spark mycrud:ai-context film
```

The intended relationship is:

```text
myCrudCI4
    → deterministic scaffolding and architecture

AI
    → optional assistant working inside those boundaries
```

AI is not required to generate or run the application.

---

# Design principles

## Explicit generated code

Generated dependencies should be readable directly in PHP.

Prefer:

```php
private FilmModel $films;
private InventoryService $inventory;
```

over runtime relation/service lookup by table name.

## Database-aware, not business-presumptive

myCrudCI4 may know:

```text
inventory.film_id -> film.film_id
```

It does not therefore assume what an application operation involving Film and Inventory should mean.

## CodeIgniter first

Generated code should remain recognizable CodeIgniter 4 application code.

myCrudCI4 is scaffolding infrastructure, not a replacement application framework.

## Regeneration safety

Staging is disposable. Developer-owned customization is persistent.

## Capability-aware generation

Resources should expose only operations supported by their actual schema and configuration.

---

# What is new in 2.9.3

Version 2.9.3 consolidates the 2.9.x architecture and includes:

- Domain Analyzer;
- Domain Analyzer available from the Tools navigation and public route;
- structural roles: Master / Transactional / Dependent / Lookup / Pivot;
- Potential Structural Roots;
- schema-aware commented Domain development guidance;
- generated Model / Entity / Service / Controller guidance;
- Resource API Controller boundary guidance;
- lifecycle-safe distinction between temporal signals and explicit state fields;
- SQL VIEW read-only regression alignment;
- many-to-many / relational view cleanup;
- explicit Model/Service application boundaries;
- release-readiness regression checks.

The core principle is:

> **Schema-aware, business-neutral.**

myCrudCI4 can use database facts to make scaffolding concrete, but application business logic remains explicit developer-owned code.

---

# Recommended project workflow

```text
Database
   ↓
Quick / Builder
   ↓
app/MyCrudConfig/
   ↓
Generate
   ↓
app/Generated/
   ↓
Diff / Review
   ↓
Publish
   ↓
Operational app/
   ↓
Generated tests + diagnostics
   ↓
Application-specific business logic
```

For new projects with many tables:

```text
Quick Global
   ↓
initial configurations
   ↓
Builder
   ↓
resource-by-resource refinement
```

---

# Documentation

Primary documentation:

- [`docs/WORKFLOW.md`](docs/WORKFLOW.md)
- [`docs/CLI.md`](docs/CLI.md)
- [`docs/CONFIGURATION.md`](docs/CONFIGURATION.md)
- [`docs/API_OPENAPI.md`](docs/API_OPENAPI.md)
- [`docs/TESTS.md`](docs/TESTS.md)
- [`docs/MCP.md`](docs/MCP.md)
- [`docs/ROADMAP.md`](docs/ROADMAP.md)
- [`docs/business-logic.md`](docs/business-logic.md)
- [`docs/domain-analyzer.md`](docs/domain-analyzer.md)
- [`docs/domain-placeholder-preview.md`](docs/domain-placeholder-preview.md)
- [`CONTRIBUTING.md`](CONTRIBUTING.md)

Development architecture documentation:

- [`docs/development/ARCHITECTURE.md`](docs/development/ARCHITECTURE.md)
- [`docs/development/ARCHITECTURE_RULES.md`](docs/development/ARCHITECTURE_RULES.md)
- [`docs/development/ADDING_A_FEATURE.md`](docs/development/ADDING_A_FEATURE.md)
- [`docs/development/FEATURE_MATRIX.md`](docs/development/FEATURE_MATRIX.md)

The operational documentation is also available inside the application at:

```text
/mycrud/docs
```

---

# Language policy

Framework technical documentation is English-first.

English is used for:

- source comments and PHPDoc;
- Builder/developer tooling;
- CLI output and diagnostics;
- generated technical guidance;
- tests;
- API/OpenAPI/MCP technical descriptions;
- project documentation.

Application-facing labels and validation messages remain localizable through CodeIgniter language files and Builder configuration.

---

# Release

Stable release:

```text
myCrudCI4 2.9.3
tag: v2.9.3
```

Clone the stable tag:

```bash
git clone --branch v2.9.3 --depth 1 https://github.com/maxgamb/myCrudCI4.git myCrudCI4
```

Stable releases are intended to remain frozen. New development should start from a new development version rather than rewriting an already published release tag.
