# myCrudCI4 2.9.1-dev16 — Related Create Unique FK Filtering

Baseline: `2.9.1-dev15`.

## Fix

Nested foreign keys used inside a Related Create form are now filtered when the FK column on the inline-created record is also `UNIQUE`.

Example: `customer.store_id -> New Store -> store.manager_staff_id`.
A staff member already referenced by `store.manager_staff_id` is no longer offered in the `Manager Staff Id` select, preventing the predictable `is_unique` validation error on submit.

The behavior is schema-driven and generic:

- normal nested FK: all related options remain available;
- nested FK + UNIQUE: IDs already consumed in the inline-created table are excluded;
- NULL values are ignored;
- filtering is applied server-side in the generated Model, using only schema-derived table/column names.

No database constraint or validation rule is weakened; this is a UX/pre-validation improvement.
