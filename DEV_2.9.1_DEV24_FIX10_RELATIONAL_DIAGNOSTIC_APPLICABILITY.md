# myCrudCI4 2.9.1-dev24-fix10 — Relational Diagnostic Applicability

This maintenance release fixes false regression failures in the generated
architecture diagnostics without changing CRUD runtime behavior.

## What was wrong

The `HasMany contestuale parent-child-parent` diagnostic inspected the current
(parent) resource Controller and required child-side return helpers such as
`PARENT_CONTEXT_FIELDS`, `parentContextFromQuery()` and
`CrudNavigationTrail::ancestorsForParent()`.

That assumption is invalid for root parents such as `country`: the parent
partial correctly creates `city` with `country_id`, `_parent_field` and `_trail`,
while the actual return-to-country helper belongs to the generated `CityController`.

The same unconditional check also produced false failures for resources such as
`category` where the relation is represented only as an M:N pivot and no enabled
hasMany partial exists.

## Fix

- HasMany context is now checked only when the current resource has an enabled
  hasMany relation.
- Resources without an applicable hasMany relation report `SKIP` instead of
  `FAIL`.
- The parent-side partial is verified for:
  - child Create route;
  - exact foreign-key propagation;
  - schema-derived `_parent_field`;
  - navigation-only `_trail`.
- Cascaded-navigation diagnostics always verify trail propagation, but require
  `parentContext*()` / `ancestorsForParent()` only when the current resource is
  itself a child with a generated parent context.

## Architecture impact

None. Model/Service ownership, explicit relational wiring, M:N pivot ownership,
and `RelationalQuerySupport` are unchanged from fix9.
