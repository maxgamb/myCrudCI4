# 2.9.1-dev24-fix11-fix15 — Baseline freeze + architecture boundary guard

This release freezes the dev24 architecture after the BaseCrudModel, static relation wiring, Related Create Offcanvas, REST/API Resource/OpenAPI, PATCH/upload, and MCP boundary work.

## Frozen architecture

- Generated Models extend `App\Models\BaseCrudModel`.
- READ operations remain in Models.
- Standard/Full WRITE operations remain in Services.
- Cross-resource reads use explicit generated Model-to-Model calls.
- Cross-resource writes use explicit generated Service-to-Service calls.
- Relation targets known at generation time are never resolved through runtime class maps or dynamic class names.
- REST API controllers own HTTP input/filter/sort policy and delegate writes to Services.
- API Resources are output-only serializers.
- MCP Resources are output-only serializers; MCP input/filter/sort policy belongs to MCP Tools.
- Related Create uses the compact Offcanvas UI while persistence stays in the existing static Service/Model architecture.

## Architecture boundary guard

`mycrud:test-all <table>` now includes one consolidated `architecture boundary guard` for BASIC, STANDARD, and FULL outputs.

The guard rejects regressions such as:

- `new $modelClass` / `new $serviceClass` relation resolution;
- `resolveModel()` / `resolveService()` runtime relation dispatch;
- legacy `createRelatedViaServices()` or `createManyToManyRelatedViaServices()` dispatchers;
- SQL/DB access inside generated Services;
- SQL/dynamic relation resolution inside REST API controllers;
- request/write/filter/sort policy inside API Resources;
- filter/sort/query policy inside MCP Resources;
- duplicated BaseCrudModel relation/cache runtime inside concrete generated Models.

It intentionally allows explicit generated dependencies such as:

```php
return (new LanguageService())->createRelated($payload);
return (new ActorModel())->relationRowsByIds(...);
```

because the relation target is fixed at generation time and visible in the generated PHP source.

## Baseline status

The preceding fix14 resolved the last false transaction diagnostic by correctly inspecting the shared `app/Models/BaseCrudModel.php`. The reported regression suite reached `FAIL 0` with only non-applicable tests skipped. fix15 adds guards and documentation only; it does not change CRUD runtime behavior.
