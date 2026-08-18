# myCrudCI4 2.9.1-dev24-fix11-fix8

## REST API + Resource + OpenAPI architecture alignment

This fix extends the dev24 static architecture rules to the Full REST stack without changing the Web Related Create Offcanvas behavior.

### REST Controller
- Model for reads.
- Service for writes.
- No direct SQL.
- No dynamic Model/Service/table resolution.
- API input whitelist is owned by the API boundary.
- Upload runtime code is emitted only when upload fields exist.

### Resource
- Output-only serializer.
- No request filtering.
- No validation.
- No Model/Service/database access.

### OpenAPI
- Describes only the actual REST contract.
- Does not expose Web-only Related Create/Offcanvas transport fields.
- Keeps field visibility and write schemas derived from the same Builder/schema configuration used by the API generator.

### Regression contracts
Generated Full tests now guard API architecture, Resource purity, expected operations, and absence of Web-only transport fields in OpenAPI.
