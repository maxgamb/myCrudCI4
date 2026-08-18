# 2.9.1-dev24-fix11-fix36 — Spark command audit

The `app/Commands/` directory registers 18 `mycrud:*` Spark commands. `docs/CLI.md` is the canonical inventory and must list every registered command exactly once using the command class usage declaration.

The audit found one omission in fix35 documentation: `mycrud:test-dashboard`. No command implementation was missing.
