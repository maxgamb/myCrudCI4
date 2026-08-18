# myCrudCI4 2.9.1-dev2-fix10 — M2M Related Create Availability

Focused fix for many-to-many inline target creation.

## Sakila verification

Expected compatible targets:

```text
film -> film_actor -> actor
actor:
- actor_id AUTO_INCREMENT
- first_name required
- last_name required
- last_update DB-managed

film -> film_category -> category
category:
- category_id AUTO_INCREMENT
- name required
- last_update DB-managed
```

Both targets are now verified as `createRelatedAvailable=true`.

## Builder

Each many-to-many card now clearly displays:

```text
Related-create: available
```

or:

```text
Related-create: unavailable
```

When unavailable, the Builder reports a concrete reason such as:

- nested foreign key;
- no writable fields;
- target is a SQL VIEW;
- unsupported required fields;
- target does not expose exactly one primary key.

The `Create new related record` option remains explicit and disabled by default
until the developer enables it.
