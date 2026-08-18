# dev24 fix11 fix37 — Release-check RC gate

Adds `php spark mycrud:release-check <table> [table ...]` as the release-candidate readiness gate.

The command composes existing checks rather than introducing a parallel validation implementation.

Per table it runs:

- `mycrud:test-all`
- `mycrud:test-generated`
- `mycrud:check-api`
- `mycrud:check-query-layer`

Project-wide it runs:

- `mycrud:test-dashboard`
- focused Shield contract tests
- CLI documentation coverage
- Dashboard/Builder architecture guards

The gate returns a non-zero exit code when any component fails and prints `READY FOR RC1` only when every gate passes. Multiple tables are accepted so a representative regression matrix can be checked in a single command.

Some checks regenerate replaceable staging under `app/Generated/`; the command never publishes to operational `app/` files.
