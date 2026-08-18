# myCrudCI4 2.9.1-dev15 — Related Create DB Diagnostics

Baseline: `2.9.1-dev14`.

## Problem

`Customer -> address_id -> New Address` is now available, but a failed parent
INSERT only reports `Unable to insert related record: address.`. That masks the
actual database reason (for example an invalid WKT spatial value, a missing
required column, a FK violation, or a DB constraint).

## Fix

- when a Related Create INSERT returns false, the generated Model reads
  `$this->db->error()`;
- the exception now includes the database error code and message;
- the same information is written through `log_message('error', ...)`;
- transaction behaviour is unchanged: the main record is not inserted and the
  transaction is rolled back.

This is deliberately generic: no Sakila-specific fallback value is invented for
`address.location`.
