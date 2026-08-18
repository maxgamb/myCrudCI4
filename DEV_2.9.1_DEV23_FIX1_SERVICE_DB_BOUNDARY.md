# myCrudCI4 2.9.1-dev23-fix1 — Service DB Boundary Fix

Generated Services remain orchestration-only. They no longer call `Database::connect()`.

For atomic cross-resource writes, the main Service delegates transaction boundaries to its own Model:

```php
$this->model->beginWriteTransaction();
// static related Service calls + current Model writes
$this->model->commitWriteTransaction();
```

On failure it calls `rollbackWriteTransaction()`. The Model owns the CodeIgniter database connection and transaction status.

This preserves the architecture rule:

- Controller: HTTP/request/response
- Service: application orchestration and resource validation
- Model: SQL, database access, and transaction primitives
