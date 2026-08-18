# myCrudCI4 2.9.1-dev24-fix11-fix11 — Static Related Create Diagnostic

This patch updates only the regression contract for STANDARD/FULL inline parent creation.

## Architecture enforced

- Controller -> current Service for writes.
- Current Service -> explicitly generated related Service for inline parent creation.
- Related Service -> its own Model through `createRelated()`.
- No runtime service/model resolver and no metadata-driven relation dispatcher.

For each enabled belongsTo Related Create, the diagnostic verifies the exact generated pattern:

```php
private function createLanguageForLanguageId(array $payload): int|string
{
    return (new LanguageService())->createRelated($payload);
}

$data['language_id'] = $this->createLanguageForLanguageId($related['language_id']);
```

BASIC keeps its existing Model-owned inline-create contract.

No runtime CRUD, REST, MCP, OpenAPI, Offcanvas, BaseCrudModel, or persistence behavior is changed.
