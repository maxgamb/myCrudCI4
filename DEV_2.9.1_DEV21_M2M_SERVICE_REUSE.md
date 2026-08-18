# myCrudCI4 2.9.1-dev21 — M2M Service Reuse

## Goal
Complete the write-ownership rule introduced in dev20 without adding new layers.

## Rule
- Controller handles HTTP and validation payload extraction.
- Service coordinates cross-resource writes.
- Model owns SQL for its own table and pivot synchronization.
- BASIC remains Model-based because it intentionally has no Service layer.

## STANDARD/FULL M2M Related Create flow

`FilmService -> ActorService::createRelated() -> ActorModel::insertRelatedPayload()`

The returned Actor ID is appended to the Film M2M association payload. `FilmModel` then inserts/updates Film and synchronizes `film_actor`; it does not insert Actor directly.

The same flow applies to any generated M2M target, for example Category.

## Transaction ownership
When a new M2M target is requested, the originating Service opens the wider transaction. Target Services insert their own resources; the current Model performs the main-resource/pivot work. Any failure rolls back the wider operation.

## Bootstrap assumption
`php spark mycrud:generate-all` remains the expected first project command. STANDARD/FULL can therefore rely on generated related Services instead of duplicating target inserts.

## Compatibility
- Existing M2M selectors and pivot synchronization stay in the current Model.
- Existing Related Create reuse from dev20 is unchanged.
- Query ownership from dev19 is unchanged.
- No registry, dependency graph, service locator, or new generated layer was introduced.
