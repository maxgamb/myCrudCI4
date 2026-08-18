# myCrudCI4 2.9.1-dev19-fix1 — Relational Model FQCN Generation Fix

This patch fixes a PHP code-generation regression introduced in dev19.

## Problem

Generated relation methods could contain an invalid class expression:

```php
new \App\Models\{LanguageModel}()
```

The braces were emitted literally by the generator heredoc.

## Fix

The generator now builds the fully-qualified related Model class name before rendering the heredoc and emits:

```php
new \App\Models\LanguageModel()
```

The same correction is applied to belongsTo option loaders and hasMany child loaders.
