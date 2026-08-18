# myCrudCI4 2.9.1-dev2-fix12 — Nullable Foreign-Key Normalization

Fixes inserts/updates where an optional foreign-key select submits an empty
string.

Example:

```text
film.original_language_id
NULL allowed
FK -> language.language_id
```

HTML sends:

```text
original_language_id = ''
```

MySQL rejects the empty string as a foreign-key value.

myCrudCI4 now normalizes only nullable foreign-key fields:

```text
'' -> NULL
```

before persistence.

The normalization exists in both the shared web input processor and generated
Service layer, so web CRUD and API/Service writes follow the same rule.

Required foreign keys are unchanged.
