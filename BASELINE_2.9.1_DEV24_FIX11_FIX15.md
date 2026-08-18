# myCrudCI4 dev24 frozen baseline

**Baseline:** `2.9.1-dev24-fix11-fix15`

This is the frozen development baseline for the dev24 architecture line.

Core invariants:

1. Controller/API boundary handles HTTP; no SQL.
2. Model owns reads and persistence for its own table/pivots.
3. Service owns Standard/Full write use-cases and orchestration; no SQL.
4. Cross-resource relations are generated as explicit static Model/Service calls.
5. `BaseCrudModel` contains shared owned-table infrastructure only and never chooses a related Model dynamically.
6. API Resource and MCP Resource are output-only serializers.
7. OpenAPI describes REST behavior and does not expose Web/Offcanvas payload internals.
8. Related Create Offcanvas is UI-only and does not alter persistence ownership.

Recommended verification after a generator change:

```bash
php spark mycrud:generate-all --force
php spark mycrud:publish-all --force
php spark mycrud:test-all film
php spark mycrud:test-all customer
php spark mycrud:check-query-layer film
php spark mycrud:check-api film
php spark mycrud:mcp-doctor film
```

The `architecture boundary guard` in `mycrud:test-all` should remain green before promoting a later baseline.


## Post-freeze guidance update

`2.9.1-dev24-fix11-fix16` keeps this architecture frozen and adds only developer-customization examples plus richer `mycrud:ai-context` guidance. The static relation, BaseCrudModel, REST/MCP and architecture-guard rules in this baseline remain authoritative.
