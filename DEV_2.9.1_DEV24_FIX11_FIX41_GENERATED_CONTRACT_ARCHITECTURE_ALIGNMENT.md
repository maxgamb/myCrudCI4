# myCrudCI4 2.9.1-dev24-fix11-fix41

This fix realigns generated PHPUnit contracts with the current explicit/static architecture. It does not change generated CRUD runtime behavior.

## Corrected contracts

- API Resources remain output-only and are checked without fragile PCRE patterns.
- Related Create no longer requires the removed generic `relatedCreateRelationOptions` method.
- Many-to-many contracts now expect explicit generated methods and reject legacy generic dispatchers.
- Service-enabled relational writes keep transaction orchestration in the Service through BaseCrudModel transaction APIs.

After installing the fix, regenerate and publish the affected CRUDs before running `mycrud:test-generated`.
