# 2.9.1-dev24-fix11-fix14 — BaseCrudModel transaction diagnostic

The architecture regression suite generates BASIC/STANDARD/FULL outputs in isolated `writable/mycrud-regression-*` trees. `BaseCrudModel` is shared application infrastructure under `app/Models`, so it is intentionally not duplicated into every isolated `Generated/Models` directory.

The STANDARD/FULL Related Create diagnostic previously looked only for `BaseCrudModel.php` inside that isolated generated tree. As a result, the transaction API check failed even though generated Models correctly inherit the methods from `App\Models\BaseCrudModel`.

The diagnostic now checks an isolated BaseCrudModel when present and otherwise falls back to the real `APPPATH/Models/BaseCrudModel.php`. It still requires all four transaction methods and does not relax the static relation ownership rules.
