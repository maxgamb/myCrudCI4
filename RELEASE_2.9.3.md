# myCrudCI4 2.9.3 — Stable

myCrudCI4 2.9.3 is a focused bugfix release based on the 2.9.2 architecture.

## Main fix

The Domain Analyzer engine, schema-aware guidance and view were already
present in 2.9.2, but the stable tag did not expose the analyzer through
the complete application UI wiring.

Version 2.9.3 adds:

- `GET mycrud/tools/domain`
- Tools → Domain Analyzer in the standard layout
- Tools → Domain Analyzer in the CRUD layout

A clean clone of `v2.9.3` therefore exposes the Domain Analyzer directly
from the myCrudCI4 user interface.

## Architecture

The existing 2.9.x architecture remains unchanged:

- Reads → Models
- Writes → Services
- Controllers → HTTP boundary
- SQL → Model/query layer
- explicit generated relation dependencies
- SQL VIEW resources remain read-only
- AI support remains optional

## Validation

Validated with:

```bash
php spark mycrud:doctor
php spark mycrud:release-check film customer staff store rental
```

Stable tag:

```text
v2.9.3
```
