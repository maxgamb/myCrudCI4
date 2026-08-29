# Roadmap

## 2.9.0 STABLE

The 2.9 stable baseline completed the Builder/config workflow, safe staging, API/OpenAPI capabilities, multipart upload, optional Shield integration, generated contract tests, local read-only MCP, Form Sections, and consolidated documentation.

## 2.9.1 stable consolidation baseline

The current dev24/fix line focuses on stability and explicit generated architecture rather than adding runtime abstraction.

Completed/consolidated areas:

- explicit generation-time relation wiring;
- Model ownership for reads and Service ownership for writes;
- feature-aware Services and persistent Service Extensions;
- Related Create and many-to-many integrity/diagnostics;
- Dashboard 2.0 typed DTO/object View boundary with dedicated regression command;
- intent-first Builder UX and sticky Parent database tables navigation;
- independent Shield Web CRUD (`session`) and REST API (`tokens`) security;
- output-only REST Resources/OpenAPI boundary;
- local read-only MCP boundary.

## Entity 2.0 consolidation

The post-2.9.1 line makes the Standard/Full write boundary explicit: Services prepare and validate, generated Entities are constructed with `fromArray()`, and Models persist typed Entities. Entity factories do not validate. Entity scope remains record-local, while transactions and cross-resource business workflows remain Service responsibilities. `DECIMAL`/`NUMERIC` fields are not automatically coerced to PHP `float`.

## Next development priorities

Prefer consolidation over new runtime features:

1. keep generated PHP explicit and understandable;
2. improve Builder guidance without changing saved contracts;
3. expand generated/runtime regression coverage where a real gap is found;
4. prepare a stable promotion only after full multi-table acceptance testing.

## Release discipline

Future stable promotion should pass:

```text
generate-all
→ diff/review
→ publish dry-run
→ publish
→ test-generated
→ test-dashboard
→ test-all
→ doctor
→ check-api
→ check-query-layer
```
