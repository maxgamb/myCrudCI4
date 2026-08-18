# myCrudCI4 2.9.1-dev2-fix4 — /mycrud UI English

Converts the developer-facing `/index.php/mycrud/` area to English:

- developer navbar;
- Home/dashboard;
- Builder;
- Quick generation;
- global generation;
- Menu Builder;
- project dashboard;
- diff/doctor/result pages;
- AI context pages;
- flash messages and controller titles.

Also repairs a second identifier corruption introduced by the previous language sweep:

- `CrudGeneratedrService` → `CrudGeneratorService`
- `AiProjectContextGeneratedr` → `AiProjectContextGenerator`
- `MenuGeneratedr` → `MenuGenerator`
- `App\Libraries\MyCrud\Generatedrs` → `App\Libraries\MyCrud\Generators`

The optional Italian application language pack remains untouched.
