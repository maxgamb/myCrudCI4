# myCrudCI4 2.9.1-dev2-fix3 — Initial Create value preview

Fixes Builder behavior for temporal fields.

The example field beside `Initial value in Create` now updates immediately when
the mode changes:

- None → `No initial value`
- Current date → current local `YYYY-MM-DD`
- Current date and time → current local datetime
- Current time → current local time
- Custom value → editable input with a type-aware example

For automatic modes the example field is read-only and does not submit a
stale custom value. Runtime generation semantics are unchanged.
