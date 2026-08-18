# myCrudCI4 2.9.1-dev16 — Related Create Stable Baseline

Baseline promoted from `2.9.1-dev16 — Related Create Unique FK Filtering`.

## Scope consolidated

This baseline consolidates the Related Create fixes introduced from dev13 through dev16:

- M2M Related Create nested FK support;
- Related Create support for required spatial/WKT fields;
- database diagnostics for failed inline related INSERTs;
- filtering of already-consumed values for nested FK columns that are also UNIQUE.

## Verified manual scenario

The Sakila-style `Customer -> Address -> City` Related Create path accepts a valid WKT spatial value such as `POINT(12.4964 41.9028)` and completes successfully.

## Regression invariants

- Related Create remains transactional;
- server-side validation and database constraints remain authoritative;
- UNIQUE validation is not weakened;
- normal nested FKs continue to expose all valid related options;
- UNIQUE nested FKs exclude values already consumed by the inline-created table;
- unsupported binary/blob requirements remain unavailable rather than being guessed.

## Version

The runtime version remains `2.9.1-dev16`. `STABLE` is a project baseline designation, not a different semantic runtime version.
