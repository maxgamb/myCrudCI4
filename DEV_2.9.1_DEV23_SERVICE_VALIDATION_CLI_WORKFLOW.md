# myCrudCI4 2.9.1-dev23 - Service Validation & CLI Workflow Consolidation

This release consolidates the static relational architecture.

- Standard/Full related writes call the related generated Service statically.
- `createRelated()` validates with that resource's generated Rules class before calling its Model.
- `mycrud:publish-all` publishes every configured CRUD from staging while preserving SAFE publish behavior.
- Recommended project baseline: `mycrud:generate-all --force`, then `mycrud:publish-all`, then per-table Builder customization.
