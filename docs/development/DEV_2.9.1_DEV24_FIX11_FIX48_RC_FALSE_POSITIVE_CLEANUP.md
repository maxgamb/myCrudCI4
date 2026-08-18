# 2.9.1-dev24-fix11-fix48 — RC false-positive cleanup

This maintenance fix removes two RC-gate false positives without changing generated runtime behavior.

## OpenAPI contract
When a CRUD has all `apiCapabilities` disabled, the generated OpenAPI document correctly contains `paths:` with no REST path entries. The generated PHPUnit contract now treats that as valid and continues to verify the document header, components, and the absence of web-only Related Create/offcanvas transport.

## Generated PHP formatting contract
The formatting regression test now executes `GeneratorTrait::formatGeneratedContent()` through a test wrapper and verifies its observable behavior: trailing whitespace removal, at most one empty line, and a final newline. It no longer depends on the literal escaping used to spell the regex in source code.

## Architecture
No runtime architecture or generation boundary changed.
