# Builder

The Builder provides a web interface for configuring a CRUD before generation.

Route:

```text
/mycrud/builder
```

## Persistent configuration

Saving a table creates or updates:

```text
app/MyCrudConfig/<table>.php
```

The persistent file stores developer choices, not a full copy of the database schema. Schema metadata is read again from the database on regeneration.

## Field configuration

Depending on the schema and field type, the Builder can configure:

- labels;
- input type;
- Bootstrap field width;
- form section;
- form/index/detail visibility;
- search and sort behavior;
- validation-related attributes;
- relation display behavior;
- relation navigation.

## Form Sections

Form Sections group Create/Edit fields without changing Model, Service or validation logic.

Each section can define:

- title;
- optional description;
- open/collapsed state;
- Bootstrap width (`col-1` through `col-12`).

Each field stores a single section reference. Unassigned fields belong to the automatic **General** section.

## Compact navigation

The Builder uses collapsible field cards and sticky navigation to reduce long-page scrolling. Field headers summarize input type, width and form section.

## Preview

The form preview reflects field widths and Form Sections before generation.

## Safe generation

The Builder generates into `app/Generated/`. Publishing to operational application folders is a separate step.
