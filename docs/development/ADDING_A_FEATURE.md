# Adding a Feature to myCrudCI4

Use this workflow before editing a generator.

## 1. Define the capability
State what the developer configures, what is derived from schema, which architectures support it, and whether it affects read, write, or both.

## 2. Map ownership

```text
Schema fact?       → DbSchema / policy
Developer choice?  → ConfigBuilder + persisted config merge
Query?             → Model
Write use-case?     → Service (Standard/Full)
HTTP/UI?            → Controller/View
REST input?         → ApiController / API rules
REST output?        → Resource
API contract?       → OpenAPI
MCP input/read?     → MCP Tool → Model
AI guidance?        → ai-context
```

## 3. Check the feature matrix

| Area | Question |
| --- | --- |
| Builder/config | Is there a developer decision to persist? |
| Schema merge | Can schema drift invalidate the choice? |
| Model | Are new queries/persistence methods required? |
| Service | Is there a write use-case or cross-resource orchestration? |
| Web | Does Create/Edit/View/Index change? |
| REST | Is the capability exposed? JSON or multipart? PUT/PATCH semantics? |
| OpenAPI | Does the public contract match implementation? |
| MCP | Is read access useful and explicitly allowed? |
| CLI | Does doctor/check-api/check-query-layer need a rule? |
| Tests | Which Basic/Standard/Full contracts prove it? |
| AI context | Does an agent need to know the new rule? |
| Docs | Does a contributor/application developer need guidance? |

## 4. Generate explicit code
If a relation target is known, emit the concrete class/method. Avoid metadata registries whose only purpose is choosing a known dependency at runtime.

## 5. Keep generation feature-aware
A table without the feature must not receive unused constants, imports, parameters, methods or dead branches.

## 6. Test representative resources
Use at least one simple CRUD and one relation-heavy CRUD. In the Sakila-style regression set, `customer` and `film` are useful representatives.

```bash
php spark mycrud:generate-all --force
php spark mycrud:test-all customer
php spark mycrud:test-all film
php spark mycrud:check-query-layer customer
php spark mycrud:check-query-layer film
php spark mycrud:check-api film
```

## 7. Review generated PHP
Do not rely only on PASS counts. Inspect the generated Model/Service/Controller/Resource for readability and absence of dead/dynamic code.

## 8. Update developer and AI contracts
If the architecture or customization workflow changes, update `docs/development/`, regression guards and `mycrud:ai-context` in the same change.
