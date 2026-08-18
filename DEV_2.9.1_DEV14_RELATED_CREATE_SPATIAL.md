# myCrudCI4 2.9.1-dev14 — Related Create Spatial FK Parent Fix

Baseline: `2.9.1-dev13`.

## Problem

A normal belongsTo Related Create was unavailable when the parent table had a
required spatial column. Sakila `customer.address_id -> address.address_id` is
the reference case because `address.location` is a required GEOMETRY column.
The UI therefore fell back to the external `New parent` link instead of showing
`Select or create new`.

## Fix

- required spatial fields no longer make belongsTo Related Create unavailable;
- spatial values are rendered as WKT text inputs (for example `POINT(0 0)`);
- generated Model converts WKT with `ST_GeomFromText()` during the atomic parent insert;
- WKT values are DB-escaped before being placed inside the trusted SQL function;
- BLOB/BINARY required fields remain unsupported;
- nested FK selects introduced before dev14 remain unchanged.

## Sakila result

`Customer -> address_id -> New Address` can now expose `city_id` as a normal
select and `location` as a WKT input, then insert Address and Customer in the
same transaction.
