# 2.9.1-dev24-fix11-fix49 — Global Related Create offcanvas width

- Adds one global `Config\MyCrud::$relationOffcanvasWidth` setting, default `640` pixels.
- Applies it to both belongsTo and many-to-many Related Create Bootstrap Offcanvas panels.
- Leaves Builder widths, `formWidth`, persistent CRUD config, and relation runtime behavior untouched.
- Generated panels use a viewport-safe `min(<configured px>, 100vw)` width.
