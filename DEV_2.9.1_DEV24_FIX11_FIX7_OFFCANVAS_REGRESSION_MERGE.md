# myCrudCI4 2.9.1-dev24-fix11-fix7

## Offcanvas regression merge

This release is based on fix11-fix6 and restores the UI improvements from fix11-fix4 without reverting the regression-recovery and explicit/static relation changes.

- Many-to-many Related Create uses a compact button + Bootstrap offcanvas.
- The inline switch UI is not generated.
- Apply/Cancel/Remove manage the pending related-create payload.
- Server validation reopens the offcanvas when the pending payload is active.
- Explicit/static Model and Service relation wiring from fix5/fix6 is preserved.
- Regression diagnostics assert the offcanvas contract.
