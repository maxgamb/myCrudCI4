# myCrudCI4 2.9.1-dev24-fix11-fix13

## Goal
Close the remaining STANDARD/FULL regression false negative for inline parent creation without changing generated runtime behavior.

## Diagnostic contract
For Standard/Full, the runner now verifies:

- the current Service accepts `array $related = []`;
- `createRelated()` validates and persists through the current Model;
- transaction begin/status/commit/rollback are available;
- each enabled belongsTo Related Create references the expected named related Service;
- each enabled relation reads `$related['field']` and assigns `$data['field']`;
- dynamic service/model resolvers and legacy Model-side related writers remain forbidden.

## Diagnostics
A failed `create record collegato` result now lists the failed structural sub-checks, making future regressions actionable.

## Runtime impact
None. ServiceGenerator, ModelGenerator, API, MCP, OpenAPI and the Offcanvas UI are unchanged.
