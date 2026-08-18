# 2.9.1-dev24-fix11-fix49 — Global Related Create offcanvas width

This fix deliberately keeps offcanvas sizing simple and project-wide. `Config\MyCrud::$relationOffcanvasWidth` defaults to `640` pixels and is resolved at generation time. Both belongsTo Related Create and many-to-many Related Create use the same value.

The setting is independent from `formWidth`: `formWidth` controls the Bootstrap grid width of a relation card inside the main form, while `relationOffcanvasWidth` controls only the lateral Bootstrap Offcanvas used to create a related record. No per-relation Builder setting or persistent CRUD metadata is added.
