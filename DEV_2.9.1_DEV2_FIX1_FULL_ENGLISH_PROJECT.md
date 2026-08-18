# myCrudCI4 2.9.1-dev2-fix1 — Full English Project Sweep

Base: 2.9.1-dev2.

This fix expands the English conversion from documentation-only to active
framework source and generated-code templates.

## Converted

- generated Controller PHPDoc/comments/runtime technical messages;
- generated Model/Service/API/Test technical comments where active;
- Builder and Quick technical UI;
- CLI descriptions, help text, diagnostics, and test runner messages;
- active myCrudCI4 controllers/views;
- generated Form/Relation technical descriptions;
- project branding from legacy `myCrudGpt` to `myCrudCI4`.

## Language boundary

English:
- framework source;
- generated PHPDoc/comments;
- technical/runtime framework messages;
- Builder/Quick/CLI developer UI;
- docs/tests/API/MCP descriptions.

Localization retained:
- `app/Language/it/` remains available as an optional application language pack.

Historical release-note files are preserved as archival material and are not
part of the active runtime/documentation surface.


## Cleanup

Legacy internal development notes written in Italian were removed from the
release package. Historical behavior remains summarized in the English
CHANGELOG and current documentation.

The Italian language pack under `app/Language/it/` is intentionally retained.
