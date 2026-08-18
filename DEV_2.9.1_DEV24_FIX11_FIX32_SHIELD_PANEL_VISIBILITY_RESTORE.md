# myCrudCI4 2.9.1-dev24-fix11-fix32 — Shield panel visibility restore

## Problem

Shield was still implemented, but fix28 moved API configuration into a collapsed advanced `<details>` block. The existing Shield UI lived inside that block, making Shield appear to have disappeared from the Builder.

## Fix

The existing `apiSecurity` controls are moved to a dedicated visible **Security / Shield** card. No security contract is reimplemented or changed.

The existing configuration keys remain:

- `apiSecurity[auth] = none|shield_tokens`
- `apiSecurity[permissions][list|read|create|update|delete|trash|restore|forceDelete|upload]`

Generated routes, OpenAPI, Shield token checks, and generated security contract tests continue to use the same implementation.

## Builder UX

The Advanced navigation now exposes a dedicated Shield entry and status:

- `On`: Shield token auth selected;
- `Ready`: Shield detected but not enabled for this CRUD;
- `Missing`: Shield package/filter not detected.

API Capabilities remain collapsed by default; Shield is no longer hidden inside them.
