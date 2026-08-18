# myCrudCI4 2.9.1-dev2-fix7 — Technical Identifiers & Paths Audit

Focused repair after the English migration.

Fixed:

- `app/Generatested/` → `app/Generated/`
- `tests/Generatested/MyCrud/` → `tests/Generated/MyCrud/`
- `Paths principali` → `Main paths`
- remaining mixed-language text in `/mycrud/docs`

Added an automated audit for:

- framework PSR-4 `use App\...` references;
- corrupted translation tokens in technical identifiers;
- canonical myCrudCI4 paths;
- the `/mycrud`, `/mycrud/builder`, and
  `/mycrud/builder/configure/<table>` routes.

No CRUD runtime behavior changed.
