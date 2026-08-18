# myCrudCI4 2.9.1-dev20 — Relational Service Reuse

## Goal
Reduce duplicated relational write logic while keeping the generated architecture simple.

## Rules
- Controller handles HTTP only.
- Service coordinates writes across resources.
- Model owns SQL for its own table.
- BASIC keeps the existing Model-based Related Create path because it has no Service layer.
- STANDARD and FULL delegate Related Create to the generated Service of the parent resource.

## Related Create flow (STANDARD/FULL)

`CustomerService -> AddressService::createRelated() -> AddressModel::insertRelatedPayload()`

The originating Service owns the wider transaction. The related Service performs application normalization and its own ServiceExtension hooks. The related Model inserts only its own table, including spatial WKT fields through `ST_GeomFromText()`.

`php spark mycrud:generate-all` is the expected project bootstrap so related Models and Services are available before CRUD customization.

## Compatibility
- FK option reads and hasMany query ownership from dev19 are unchanged.
- M2M related-create write reuse is intentionally deferred.
- BASIC behavior is unchanged.
