# myCrudCI4 2.9.1-dev13 — Many-to-many Related Create FK Fix

Baseline: `2.9.1-dev12`.

## Problem

N:N `Create new related record` was marked unavailable whenever the final
target contained any foreign key.

This was too restrictive.

Example:

```text
Category -> film_category -> Film
Film.language_id -> Language
Film.original_language_id -> Language
```

Those Film foreign keys can be handled by normal select controls.

## Fix

A target foreign key is now accepted when:

- parent table is known;
- parent key is known;
- display field is known;
- option mode is `select`.

The inline N:N form renders that field as a select.

The generated Model provides the option lists and validates the selected parent
row again before inserting the new target record.

## Safety

A nested FK still makes the feature unavailable when it needs unsupported
handling such as AJAX-only nested relation selection.

No query was moved into generated Views.
