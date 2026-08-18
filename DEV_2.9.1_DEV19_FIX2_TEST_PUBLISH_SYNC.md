# myCrudCI4 2.9.1-dev19-fix2 – Generated Test Publish Sync

Normal `mycrud:publish <table>` now always refreshes generated PHPUnit contracts from `app/Generated/Tests/` into `tests/Generated/`.

Application files remain protected by SAFE publish unless `--force` is explicitly used.

This fixes stale MCP contract expectations after regenerated relation metadata changes.
