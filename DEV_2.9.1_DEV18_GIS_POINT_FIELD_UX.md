# myCrudCI4 2.9.1-dev18 — GIS Point Field UX

## Scope
Improves POINT spatial fields inside Related Create without changing the proven persistence layer.

- POINT is edited as Latitude + Longitude.
- Latitude range: -90..90.
- Longitude range: -180..180.
- The generated form converts the pair to WKT `POINT(longitude latitude)`.
- Existing WKT payload state is parsed back into the two controls after validation errors.
- The generated Model continues to persist spatial values with `ST_GeomFromText()`.
- Other spatial types remain WKT-based.

This intentionally does not add maps, geocoding, POLYGON or LINESTRING editors.
