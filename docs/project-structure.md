# Project structure

Important myCrudCI4 paths:

```text
app/
├── Commands/
│   └── MyCrud*.php
├── Config/
│   ├── MyCrud.php
│   └── MyCrudRoutes.php
├── Controllers/
│   └── MyCrud/
├── Libraries/
│   └── MyCrud/
├── MyCrudConfig/
├── Views/
│   └── mycrud/
├── Generated/
└── Routes/
```

## Generator code

```text
app/Libraries/MyCrud/
```

Contains schema inspection, configuration resolution, generators, templates and diagnostics.

## Persistent developer configuration

```text
app/MyCrudConfig/
```

Contains versionable per-table choices.

## Safe staging

```text
app/Generated/
```

Contains generated application code before publishing.

## Operational generated route fragments

```text
app/Routes/
```

The application `Config/Routes.php` can load these fragments without continuously rewriting one central route file.

## Technical naming compatibility

The public product name is **myCrudCI4**, while technical identifiers intentionally remain:

```text
App\Libraries\MyCrud
Config\MyCrud
app/MyCrudConfig/
mycrud:* CLI prefix
```

This avoids an unnecessary breaking rename.
