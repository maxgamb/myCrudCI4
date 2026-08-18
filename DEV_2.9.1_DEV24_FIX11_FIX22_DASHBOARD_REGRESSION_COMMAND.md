# myCrudCI4 2.9.1-dev24-fix11-fix22 — Dashboard regression command

Adds a first-class Dashboard regression command:

```bash
php spark mycrud:test-dashboard
```

The Dashboard is project-wide, so no table argument is required. The command validates the 10 staged Dashboard files, config-array/DTO-object boundaries, and—when published—executes `DashboardService::build()` and checks typed widget payloads. `mycrud:test-all <table>` also includes these checks when a generated Dashboard exists.
