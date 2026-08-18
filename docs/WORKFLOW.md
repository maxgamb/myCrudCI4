# Recommended Workflow

myCrudCI4 separates design/configuration from execution.

```text
Database
→ Builder
→ app/MyCrudConfig/<table>.php
→ Quick / CLI
→ app/Generated/
→ Diff / Review
→ Publish
→ app/ + tests/
→ Test Generated
```

## 1. Configure in Builder

Use Builder for architecture, fields, relations, Form Sections, uploads, Web CRUD security, REST API security, and MCP. Save the persistent table configuration.

The `Parent database tables` card is sticky on desktop and follows the page scroll. It intentionally has no independent vertical scrollbar.

## 2. Generate the project baseline

For the normal project workflow, generate every saved CRUD first:

```bash
php spark mycrud:generate-all --force
```

This creates the Models and, for Standard/Full architectures, the Services used by static relational calls between resources. Generation writes to `app/Generated/`, not directly to operational application code.

For a focused regeneration you can still use:

```bash
php spark mycrud:regenerate film
```

## 3. Review

```bash
php spark mycrud:diff film
php spark mycrud:publish film --dry-run
```

## 4. Publish

After `generate-all`, publish the complete generated baseline with:

```bash
php spark mycrud:publish-all
```

Use `--dry-run` to review the copy plan and `--force` only when an intentional overwrite has been reviewed. A single CRUD can still be published with `php spark mycrud:publish film`.

## 5. Test

```bash
php spark mycrud:test-generated film
```

For broader validation also run `mycrud:test-all`, `mycrud:test-dashboard`, `mycrud:doctor`, `mycrud:check-api`, and `mycrud:check-query-layer`.

## Design rule

Builder is the single configuration authority for application decisions.
Quick and CLI must consume the same saved configuration rather than implementing
a second configuration model.

## Relational ownership and validation

Generated relations use static PHP references known at generation time. Parent/child reads are delegated to the owning related Model. Related writes are delegated to the owning related Service in Standard/Full architectures. Each related Service validates its own payload with its generated `<Resource>Rules::createRules()` before persistence. The originating Controller may pre-validate inline form payloads for field-level UX, but the related Service remains the write-side validation boundary.


## Read/write ownership (2.9.1-dev24)

Generated code no longer routes read operations through one-line Service wrappers. In Standard/Full, Controllers and API endpoints use the generated Model for reads and the generated Service for writes. Read-only MCP tools also use the Model directly. Services remain the validation/orchestration boundary for writes and may call related Services through static generated PHP references.

```text
Read:  Controller/API/MCP -> Model
Write: Controller/API -> Service -> Model
Related write: Service -> RelatedService -> RelatedModel
```

This removes legacy indirection while preserving the existing query-layer rule: Services contain no SQL and no direct database connection.


## Feature-aware Services (2.9.1-dev24-fix1)

Generated Services contain only the write features used by the current table. A table without Related Create or many-to-many relations receives simple `create(array $data)` and `update($id, array $data)` methods, without unused relation parameters or transaction boilerplate. Each write entry point validates with the resource's own generated Rules. Models without operational many-to-many relations expose `updateRecord()`; `updateRecordWithManyToMany()` is reserved for actual many-to-many synchronization.
