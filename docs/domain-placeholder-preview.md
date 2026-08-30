# Domain Analyzer — Development Guidance & Commented Code Examples

`Tools > Domain Analyzer` translates structural analysis into developer guidance without inventing business logic.

For each resource the page combines:

- structural role (`master`, `transactional`, `dependent`, `lookup`, `pivot`, `view`);
- structural-root candidacy and score;
- parents and children;
- lifecycle/event fields;
- visible structural evidence.

## Development guidance

The guidance is collapsed by default to keep the analyzer readable. It describes the expected responsibility of Entity, Service, Model and Controller. SQL views intentionally receive read/query guidance only.

## Commented code examples

The nested **Commented code examples** action shows **schema-aware, business-neutral PHP examples** tailored to the **structural role and structural-root candidacy** of the resource.

The examples are read-only and are not written to application files. When the schema provides enough evidence, the preview uses the real table name, generated class stem, FK columns, parent/child tables, related Service names, meaningful columns and detected lifecycle fields. It no longer invents generic columns merely to make an example compile.

For example, a dependent resource may show its real `child_table.parent_fk -> parent_table.parent_pk` relation, while a two-FK pivot may show its two real FK columns. A transactional example uses a real detected lifecycle field when one exists; if none exists, the preview explicitly refuses to invent a `status` field.

The examples follow the project responsibility split:

- **Entity** — record-local behavior, invariants and derived representation;
- **Service** — approved business operations and write orchestration;
- **Model** — resource-specific read/query methods;
- **Controller** — thin HTTP boundary that delegates business operations to the Service.

The preview does not define required MyCrud APIs and does not rely on managed insertion markers.

The analyzer may derive neutral method names from schema syntax (for example `findByFilmId()` from `film_id`), but it never invents business operations such as `returnRental()`, `closePayment()` or `activateCustomer()`. Business names and semantics require explicit application requirements.

Structural classification selects the base example, while **Potential structural root YES/NO materially changes the Service and Controller guidance for root-capable roles**:

- **Master + Root YES** — the Service may be shown as a candidate use-case entry point and may coordinate child Services when an explicit requirement crosses those relations;
- **Master + Root NO** — the example stays local to the resource and explicitly avoids cross-resource orchestration by default;
- **Transactional + Root YES** — the Service example may own an approved transition, cross-resource coordination and the transaction boundary when atomic writes are really required;
- **Transactional + Root NO** — the example keeps lifecycle/state behavior local and does not promote the resource to process coordinator;
- **Dependent** — parent-scoped creation/rules and parent-scoped queries; these resources are not promoted to structural roots by the current analyzer;
- **Lookup** — deliberately minimal behavior and reference-data queries;
- **Pivot** — relationship behavior only when generated many-to-many support is not sufficient;
- **View** — read-only Model/query extension.

A later write feature, if introduced, must still define regeneration safety explicitly. Developer-owned business code must never be silently overwritten by regeneration.

The root score is displayed as evidence, but no score invents a business operation. The application requirement remains authoritative.
