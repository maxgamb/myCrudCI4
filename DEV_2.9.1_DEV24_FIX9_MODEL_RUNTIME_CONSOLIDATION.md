# myCrudCI4 2.9.1-dev24-fix9 — Model Runtime Consolidation

This maintenance release completes the dev24 cleanup without adding CRUD features.

- fixes generated Service validation wiring: create/update now pass both generated rules and generated custom messages;
- moves the three reusable owned-table relational query primitives (`relationOptionRows`, `relationRowsByIds`, `childrenByForeignKey`) into `App\Libraries\Crud\RelationalQuerySupport`;
- generated Models now keep domain-specific parent/child/M:N methods while sharing only infrastructure code through the trait;
- Service transaction bridge methods are emitted only for resources whose configured write use-cases can actually span related records or pivots;
- PHPDoc documents ownership and every shared relational query operation.

The architecture remains static: generated methods select the related Model at generation time; the trait only queries the consuming Model's own `$table`.
