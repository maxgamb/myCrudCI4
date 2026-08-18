# myCrudCI4 2.9.1-dev19 — Relational Query Ownership

## Goal

Reduce duplicated cross-table query code without adding architectural machinery. The normal project workflow starts with `php spark mycrud:generate-all`, therefore Models for related tables are available before per-table customization.

## Rule

- Query on the current table -> current Model.
- Parent/FK option query -> parent Model.
- Child/hasMany query -> child Model.
- JOIN whose result represents the current resource -> current Model.
- Controller -> no SQL.

## Generated reusable Model surface

Every generated Model exposes two schema-whitelisted methods:

- `relationOptionRows()` for option/search reads on its own table.
- `childrenByForeignKey()` for child reads filtered by one of its real FK fields.

The methods validate requested field names against generated schema constants before composing a query.

## Example

For `customer.address_id -> address.address_id`, Customer's FK option wrapper calls `AddressModel::relationOptionRows()`.

For `hotel -> prenotazione` through `prenotazione.hotel_id`, the generated Hotel hasMany wrapper calls `PrenotazioneModel::childrenByForeignKey('hotel_id', ...)`.

## Scope

This release reorganizes relational READ queries only. Related Create persistence remains unchanged to avoid mixing a query refactor with transaction/write refactoring.
