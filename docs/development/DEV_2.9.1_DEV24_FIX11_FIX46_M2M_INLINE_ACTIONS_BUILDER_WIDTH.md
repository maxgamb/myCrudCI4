# 2.9.1-dev24-fix11-fix46 — M2M inline actions and Builder width

This UI-only refinement makes the generated many-to-many selector behave like the belongsTo control: the primary Search action and the optional New-related action are attached in one Bootstrap input group.

The outer relation width is now a per-relation Builder choice (`relationsConfig.manyToMany.*.formWidth`). Allowed choices come from `Config\MyCrud::$bootstrapFieldWidths`; `Config\MyCrud::$relationPanelWidths['manyToMany']` remains the default for relations without a persisted choice.

No Model, Service, API, MCP, Shield, or Dashboard runtime boundary changes.
