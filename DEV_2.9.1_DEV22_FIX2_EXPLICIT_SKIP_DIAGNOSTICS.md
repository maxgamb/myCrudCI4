# myCrudCI4 2.9.1-dev22-fix2 — Explicit SKIP diagnostics

This maintenance fix makes regression output unambiguous. `mycrud:test-all` prints `SKIP` explicitly for non-applicable contracts. The many-to-many related-create persistence check now explains whether the table has no M2M relation at all or has M2M relations for which related-create is unavailable. No generated CRUD runtime behavior is changed.
