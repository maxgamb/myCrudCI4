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
