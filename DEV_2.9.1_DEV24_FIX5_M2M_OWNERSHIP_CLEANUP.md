# myCrudCI4 2.9.1-dev24-fix5 — M2M Ownership Cleanup

- Controller formatting cleanup: separate runtime initializations on distinct lines.
- Removes generated relation-specific attach/detach/sync methods that duplicated `applyManyToMany()`.
- M2M target option/read/validation queries are delegated statically to the target Model.
- The current Model owns only its own table plus its pivot tables.
- Adds `relationRowsByIds()` as a reusable owned-table lookup for static cross-model reuse.
- Keeps Service responsibilities unchanged: validation, normalization and cross-resource write orchestration.
