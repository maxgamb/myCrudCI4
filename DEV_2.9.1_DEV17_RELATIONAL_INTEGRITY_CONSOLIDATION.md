# myCrudCI4 2.9.1-dev17 — Relational Integrity Consolidation

## Goal
Consolidate the relational layer reached in dev13-dev16 before adding new relational features.

## Generated test scaffold
When the CRUD has enabled Related Create, hasMany or many-to-many relations, `TestScaffoldGenerator` now emits:

`<Resource>RelationalContractTest.php`

The contract is intentionally non-destructive and checks only behavior derivable from configuration:

- Related Create validation keys and generated controller/model hooks;
- many-to-many persistence and Related Create hooks;
- hasMany detail loader presence;
- transaction begin/commit/rollback for atomic creates;
- UNIQUE nested-FK option filtering when required.

## Internal regression coverage
`tests/MyCrud/RelationResolverRelatedCreateIntegrityTest.php` protects two cases found during Sakila validation:

1. `customer.address_id -> address.city_id` with required spatial `location`;
2. `customer.store_id -> store.manager_staff_id` where the nested FK is UNIQUE.

## Safety
No fixture or destructive DB test is generated. Runtime business behavior remains unchanged from dev16.
