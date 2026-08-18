# myCrudCI4 2.9.1-dev2-fix9 — Many-to-many Create new related record

Adds an optional Builder capability for pure many-to-many relations.

## Example

`film ↔ actor` through `film_actor`.

The Film form can now:

1. select existing Actor records;
2. optionally enter one new Actor inline;
3. validate the new Actor server-side;
4. create the Actor inside the same main CRUD transaction;
5. append the generated `actor_id` to the selected IDs;
6. synchronize `film_actor`.

## Builder

New per-relation option:

`Create new related record`

The option is available only when the target schema is safe for this first
implementation: writable base table, single PK, standard fields, no nested FK fields.

## Atomicity

The Model creates the target row and pivot association inside the same transaction
used for the main Create/Update operation. Any failure rolls everything back.

## Not included

- inline editing of a related target;
- multiple new target rows in one relation/submission;
- nested FK creation inside the new N:N target form.
