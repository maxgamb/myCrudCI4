# 2.9.1-dev24-fix11-fix42 — API Resource contract escaping

This fix corrects the generated `ApiResourceContractTest::testResourceIsOutputOnly()` syntax.

The generator previously emitted namespace fragments with a trailing backslash inside a single-quoted PHP string. After heredoc escaping this could become an invalid generated literal such as `App\Services\'` and stop PHPUnit before the suite was loaded.

The generated contract now checks safe namespace fragments without a trailing separator:

- `App\\Models`
- `App\\Services`

No runtime CRUD code changes are included. The change is limited to generated test contracts and their regression guard.
