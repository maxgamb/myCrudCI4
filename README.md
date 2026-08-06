# myCrudGpt 2.0

Generatore RAD per CodeIgniter 4 basato sullo schema del database.

## Novità 2.0

La generazione delle view usa un motore a template interno:

- `app/Libraries/MyCrud/Template/TemplateEngine.php`
- `app/Libraries/MyCrud/Templates/views/*.tpl.php`

Le view generate sono leggibili e riutilizzano `_form.php` per create/edit.

## Label

- Label vuota nel Builder: `lang('Fields.nome_campo')`
- Label compilata nel Builder: testo personalizzato

## Architetture

- Basic: Controller + Model + Validation + Views
- Standard: Basic + Entity + Service
- Full: Standard + API

## Test

```bash
php tests/run_generator_tests.php
```

Il test genera Basic, Standard e Full e applica `php -l` ai file generati.
