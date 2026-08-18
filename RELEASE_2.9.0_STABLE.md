# myCrudCI4 2.9.0 STABLE

Baseline promoted from `2.9.0-dev14-fix3`.

No new feature is introduced by this promotion.

Release criteria completed by project testing:

- generated CRUD contract tests;
- generator regression suite;
- doctor;
- API checks;
- query-layer checks;
- Basic / Standard / Full generation workflow.

The stable workflow is:

```text
Database
→ Builder
→ app/MyCrudConfig/<table>.php
→ Quick / CLI
→ app/Generated/
→ Diff / Review
→ Publish
→ app/ + tests/
→ Test Generated
```

`Builder` is the single design/configuration point.
`Quick` and `CLI` execute the persisted configuration.
