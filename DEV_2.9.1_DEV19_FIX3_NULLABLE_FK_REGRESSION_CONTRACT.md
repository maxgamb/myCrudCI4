# myCrudCI4 2.9.1-dev19-fix3 – Nullable FK Regression Contract Fix

This is a diagnostic-suite fix on top of `2.9.1-dev19-fix2`.

`mycrud:test-all` incorrectly reported nullable foreign-key normalization as missing because the regression runner searched generated Controllers for `CrudInputProcessor::process`, while the generated Controller correctly invokes the runtime through `$this->inputProcessor->process(...)`.

The runtime write path was already correct: nullable FK values submitted as an empty string are converted to `null` before persistence. Standard and Full architectures also keep their Service-level defensive normalization.

Expected Film regression result after this fix: `PASS 291 | WARN 0 | FAIL 0 | SKIP 0` (assuming no unrelated schema/configuration changes).
