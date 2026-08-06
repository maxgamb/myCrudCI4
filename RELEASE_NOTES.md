# myCrudGpt 2.1.0 — View Generator Refactoring

- `ViewGenerator` ridotto a coordinatore.
- Generatori specializzati: Form, Index, Detail/HasMany e Trash.
- `TemplateEngine` legge i template come testo e non esegue PHP.
- Template con estensione `.tpl`.
- Placeholder coerenti e controllo automatico dei placeholder non risolti.
- Label vuota: `lang('Fields.nome_campo')`.
- Label personalizzata: stringa esplicita.
- `_form.php` condiviso da create/edit con variabili passate esplicitamente.
- Codice generato formattato e leggibile.
