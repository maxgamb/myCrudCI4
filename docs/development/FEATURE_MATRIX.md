# Feature Impact Matrix

This matrix is a contributor checklist, not a promise that every feature is exposed at every boundary. Verify the current generator/config before changing behavior.

| Feature | Builder/config | Model | Service | Web | REST | OpenAPI | MCP | AI context | Regression |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| belongsTo/FK | ✓ | ✓ | write orchestration when needed | ✓ | IDs/policy | when exposed | read when enabled | ✓ | ✓ |
| HasMany | ✓ | ✓ | only if write use-case exists | ✓ | explicit only | explicit only | read when enabled | ✓ | ✓ |
| Many-to-many | ✓ | ✓ | ✓ | ✓ | when enabled | when exposed | read when enabled | ✓ | ✓ |
| Related Create | ✓ | ✓ | ✓ Standard/Full | ✓ Offcanvas | not a Web transport contract | no Web keys | explicit only | ✓ | ✓ |
| Upload | ✓ | ✓ | ✓ | ✓ | multipart when enabled | ✓ | explicit only | ✓ | ✓ |
| Dashboard | ✓ | concrete Models + aggregate query layer | composition | ✓ typed DTO View boundary | explicit only | explicit only | explicit only | ✓ | ✓ |
| Shield security | ✓ (`crudSecurity` / `apiSecurity`) | — | — | session + permissions | tokens + permissions | Bearer scheme when enabled | independent | ✓ | ✓ |
| SQL VIEW | derived/read config | ✓ read-only | no write Service | read-only | GET-only when enabled | GET-only | read when enabled | ✓ | ✓ |

When adding a feature, use this table to ask which columns need work; do not automatically implement every boundary.


## Dashboard 2.0

Dashboard widgets use generated DTOs (`DashboardData`, `DashboardWidget`, `RecentRecord`) and concrete Model wiring for record-shaped Recent widgets. Aggregate widgets continue to use `DashboardQuery`.
