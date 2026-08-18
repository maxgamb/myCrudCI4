# myCrudCI4 2.9.1-dev24-fix11-fix38 — RC gate test recovery

Fix38 repairs three test-side regressions exposed by `mycrud:release-check`:

- generated Web Shield contract tests now escape runtime variables in the generator heredoc and validate `SessionAuth`;
- `ShieldCrudApiSeparationTest` no longer interpolates `$this` inside its expected source string;
- `CliDocumentationCoverageTest` resolves the project root independently instead of requiring `APPPATH`;
- release-check failure summaries prefer the first concrete PHPUnit defect when available.

No CRUD, Dashboard, API or Shield runtime contract is changed. Existing published generated tests must be regenerated/published before rerunning the RC gate.
