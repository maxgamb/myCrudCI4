# 2.9.1-dev24-fix11-fix47 — M2M form width persistence

## Problem

`formWidth` was accepted by the Builder and consumed by `FormViewGenerator`, but `CrudConfigRepository::toPersistentConfig()` dropped it from the persistent `manyToMany` configuration. After saving and regenerating, the relation therefore fell back to the project default (normally `12`).

## Contract

The Builder-selected width is now persisted per relation:

```php
'relationsConfig' => [
    'manyToMany' => [
        'many__film_actor__film_id' => [
            // ...
            'formWidth' => 6,
        ],
    ],
],
```

The value is normalized against `Config\MyCrud::$bootstrapFieldWidths`. `Config\MyCrud::$relationPanelWidths['manyToMany']` remains only the initial/fallback default.

The generated View continues to resolve the persisted value at generation time; no runtime relation resolver is introduced.
