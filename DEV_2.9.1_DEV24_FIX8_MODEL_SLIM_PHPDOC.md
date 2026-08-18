# myCrudCI4 2.9.1-dev24-fix8 — Model Slim & PHPDoc Consolidation

This maintenance release continues the dev24 architecture cleanup without adding new CRUD features.

## Goals

- keep generated Models focused on active query/persistence responsibilities;
- stop emitting empty legacy relation metadata constants;
- keep explicit parent/child/M2M methods generated at build time;
- remove dead Controller variables and unused helper parameters;
- preserve PHPDoc on generated operations and cross-layer calls;
- fix Service validation wiring so generated custom messages are passed to the validator.

## Model cleanup

The generator no longer emits metadata maps when no generated method consumes them. In particular, `RELATED_CREATE_RELATIONS` and the old generic `MANY_TO_MANY` metadata map are removed from Standard/Full generated Models. `RELATED_CREATES`, `MANY_TO_MANY_RELATED_CREATES`, `PRIMARY_KEYS`, and spatial metadata are emitted only when their generated code paths require them.

The explicit relation API introduced in fix6/fix7 is preserved. Generic owned-table query primitives (`relationOptionRows`, `relationRowsByIds`, `childrenByForeignKey`) remain because generated Models currently call them across resources; they are not dead code and are deliberately kept until they can be replaced safely by a common runtime abstraction.

## Controller cleanup

Generated Controllers no longer create empty `$related` / `$manyToManyNew` variables when the corresponding feature is disabled. `manyToManyDataFromPost()` no longer receives an unused boolean argument.

## Validation fix

`validateCreatePayload()` and `validateUpdatePayload()` now pass `Rules::messages()` to the shared Service validator, matching the four-argument validator signature and preserving generated custom messages.

## Architecture

- Controller: HTTP flow, request parsing, response/redirect.
- Service: validation, normalization, write orchestration, cross-Service calls.
- Model: own-table SQL, explicit relation reads, owned-pivot persistence.
