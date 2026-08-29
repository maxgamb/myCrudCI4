# Architecture Rules

These rules are the development contract for myCrudCI4.

- **AR-001 — Schema authoritative.** Physical schema facts come from the live DB; persisted config stores developer choices.
- **AR-002 — Static relational wiring.** Schema-known relation targets generate explicit concrete Model/Service calls.
- **AR-003 — Query ownership.** SQL and query composition belong to Models.
- **AR-004 — Write orchestration.** Standard/Full application writes and cross-resource write use-cases belong to Services.
- **AR-005 — Persistent customization.** Application custom logic belongs in protected persistent extension points, not `app/Generated/`.
- **AR-006 — Replaceable generated staging.** `app/Generated/` can be deleted and regenerated without losing developer custom code.
- **AR-007 — Output-only Resources.** REST and MCP Resources serialize output only.
- **AR-008 — Feature-aware generation.** Do not emit helpers, parameters, imports or methods for capabilities the resource does not use.
- **AR-009 — No hidden runtime magic.** Do not introduce runtime Model/Service/table resolution when generation-time information is available.
- **AR-010 — Boundary consistency.** Evaluate every feature against Web, Model, Service, REST, OpenAPI, MCP, CLI, diagnostics, tests, docs and AI context as applicable.
- **AR-011 — BaseCrudModel scope.** BaseCrudModel contains reusable current-table infrastructure, never relation-target discovery.
- **AR-012 — Contract tests test behavior/structure.** Regression diagnostics must not depend on irrelevant whitespace or one exact generated formatting.
- **AR-013 — Database-managed fields remain DB-owned.** They are not re-enabled by persisted UI configuration or application payloads.
- **AR-014 — UI is not an API contract.** Web-only mechanisms such as Offcanvas state and form transport keys must not leak into REST/OpenAPI unless explicitly designed as API behavior.


## AR-015 — Dashboard static read wiring

Dashboard aggregate/statistical reads belong to `DashboardQuery`. Record-shaped Recent widgets reuse concrete CRUD Models chosen at generation-time and normalize Entity/object/array results through Dashboard DTOs before rendering. Do not generate `new $modelClass()` or a runtime Model resolver when Dashboard configuration already identifies the Model.

- **AR-016 — Entity construction is not validation.** In Standard/Full writes, Services validate and prepare payloads before constructing the generated Entity with `fromArray()`; the factory does not replace validation.
- **AR-017 — Entity scope.** Entity behavior is record-local: casts, dates, accessors, mutators and local invariants. SQL, transactions and cross-resource orchestration belong outside the Entity.
- **AR-018 — Exact decimals.** Database `DECIMAL`/`NUMERIC` values must not be automatically cast to PHP `float`; exact financial/domain decimals must remain representable without binary floating-point coercion.
- **AR-019 — Regeneration lifecycle.** `--force` is a scaffolding tool. Once published application files have been customized, overwriting them requires explicit review/diff; persistent Service Extensions remain the preferred regeneration-safe business customization point.
