# Getting started

myCrudCI4 runs inside a CodeIgniter 4 application and uses the application's database connection.

## 1. Install into a test project first

The current community beta is distributed as application source rather than as a standalone Composer package.

Copy/merge the provided `app/` files into a CodeIgniter 4 test project. Review existing files before replacing them, especially:

```text
app/Config/Routes.php
app/Config/MyCrud.php
app/Views/layouts/
```

The supplied `Config/Routes.php` loads:

```php
require APPPATH . 'Config/MyCrudRoutes.php';
```

and also loads generated route fragments from:

```text
app/Routes/*.php
```

If your project already has a custom `Routes.php`, merge these parts rather than blindly replacing the file.

## 2. Configure the database

Use the normal CodeIgniter 4 database configuration for your application. myCrudCI4 reads the existing schema; it does not maintain a separate schema definition.

## 3. Open the Builder

The Builder route is:

```text
/mycrud/builder
```

Choose a table, configure fields and features, then save.

Persistent table configuration is written to:

```text
app/MyCrudConfig/<table>.php
```

## 4. Generate into staging

From the Builder or CLI:

```bash
php spark mycrud:generate film
```

Generated files are written under:

```text
app/Generated/
```

Existing staging files are not overwritten unless `--force` is used.

## 5. Review

Before publishing:

```bash
php spark mycrud:diff film
php spark mycrud:publish film --dry-run
```

## 6. Publish

```bash
php spark mycrud:publish film
```

This copies the CRUD files from `app/Generated/` into their operational paths under `app/`. Staging remains intact.

To overwrite operational files that differ:

```bash
php spark mycrud:publish film --force
```

Use force intentionally.

## 7. Run diagnostics

```bash
php spark mycrud:doctor film
php spark mycrud:test-all film
```

The exact test commands you can run depend on the database table and project configuration.
