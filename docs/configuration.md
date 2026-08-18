# Configuration

Global myCrudCI4 settings live in:

```text
app/Config/MyCrud.php
```

Per-table developer choices live in:

```text
app/MyCrudConfig/<table>.php
```

## Global configuration

`Config\MyCrud` includes defaults for:

- generated staging path;
- persistent config path;
- default architecture;
- pagination;
- exports;
- relation AJAX thresholds;
- benchmark defaults;
- upload settings;
- ignored tables;
- display-field candidates.

## Table configuration

Persistent table configuration can include:

- architecture;
- field order;
- field labels and input types;
- Bootstrap widths;
- Form Sections;
- relation behavior;
- list behavior;
- feature switches.

The persistent configuration intentionally excludes a full schema snapshot.

## Schema drift

When the database schema changes, myCrudCI4 can detect drift between the saved configuration fingerprint and the current database.

The generation workflow still rebuilds from the current database schema and reapplies compatible developer choices.

Use:

```bash
php spark mycrud:diff <table>
php spark mycrud:doctor <table>
```

before publishing changes to an important application.
