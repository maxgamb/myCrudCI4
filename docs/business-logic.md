# Business Logic, Services and Entities

This document defines where application-specific behavior belongs after myCrudCI4 has generated the CRUD baseline.

## Standard/Full write pipeline

```text
Controller / API Controller
        ↓
Service
  ├─ prepareData()
  ├─ generated validation
  ├─ beforeCreate()/beforeUpdate()
  ├─ transaction / orchestration when required
  ↓
Entity::fromArray($data)
  ├─ casts
  ├─ dates
  ├─ accessors / mutators
  └─ record-local behavior
  ↓
Model
  ├─ persistence
  ├─ queries
  └─ explicit relations
        ↓
Database
```

## `fromArray()` does not validate

A generated factory such as:

```php
public static function fromArray(array $data): self
{
    return new self($data);
}
```

only constructs the Entity. Required fields, formats and generated application validation remain a Service concern and run before Entity construction. CI4 `$casts`, `$dates` and `$datamap` likewise describe representation/mapping; they are not validation rules.

## Responsibility rule

**Controller:** HTTP request/response, redirects and boundary context.

**Service:** write use-cases, validation/normalization, transactions, state transitions and coordination across Models/resources.

**Entity:** one record. Use it for casts, dates, accessors/mutators, derived values and invariants that depend only on that record. Do not query the DB or coordinate other resources from an Entity.

**Model:** SQL/query composition, persistence and explicit relation access.

**Service Extension:** persistent create-only customization for business hooks that must survive regeneration.

## Example

A reservation method that calculates nights from check-in/check-out can be record-local Entity behavior. An operation that cancels a reservation and also changes room availability, account state or payments is a Service workflow and normally belongs in the Service/Service Extension transaction boundary.

## Exact decimal values

Generated Entity casts do not automatically map database `DECIMAL`/`NUMERIC` columns to PHP `float`. This avoids unnecessary binary floating-point coercion for money and other exact decimal domains. Use explicit domain handling when arithmetic rules require it.

## Regeneration lifecycle

```text
Database schema
→ Builder/configuration
→ Generate into app/Generated/
→ Test / diff / review
→ Publish
→ Application development
```

During scaffolding, replaceable staging may be regenerated with `--force`. After intentional customization of published application files, treat them as application code: review diffs and Git history before destructive overwrite. Prefer Service Extensions for business logic that must remain regeneration-safe.
