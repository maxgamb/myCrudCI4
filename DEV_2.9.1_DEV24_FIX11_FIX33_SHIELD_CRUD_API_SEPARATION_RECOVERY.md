# myCrudCI4 2.9.1-dev24-fix11-fix33 — Shield CRUD/API separation recovery

This recovery restores the two independent Shield security surfaces expected by the Builder.

## Web CRUD

- `crudSecurity[auth] = shield_session` protects the generated CRUD route group with Shield's `session` filter.
- Optional permissions are generated explicitly per action: list/export, detail, create, update, delete, trash, restore and force-delete.
- The configuration is available for Basic, Standard and Full architectures because it protects browser CRUD routes, not REST.

## REST API

- Existing `apiSecurity[auth] = shield_tokens` remains unchanged.
- API permissions remain capability-based and explicit.
- API Shield settings are effective with Full architecture.

## Architecture rule

The Builder stores intent, while `RouteGenerator` writes concrete Shield filters at generation-time. No runtime security resolver is introduced.
