# myCrudGpt 2.8.0-dev39 fix5 — Form Layout Rewrite

## Obiettivo

Eliminare la doppia fonte di verita introdotta dalle prime implementazioni delle sezioni form.

## Struttura canonica

```php
'formLayout' => [
    'sections' => [
        'general' => [
            'title' => 'Dati generali',
            'icon' => 'bi-card-list',
            'gutter' => 3,
            'collapsible' => false,
            'collapsed' => false,
            'order' => 10,
            'fields' => ['first_name', 'last_name', 'email'],
        ],
    ],
    'unsectioned' => ['notes'],
],
```

`fields[*].section` non viene piu persistito. Il Builder puo usare drag/drop e select come controlli temporanei, ma al submit compila una sola struttura `formLayout`.

## Migrazione

Le configurazioni dev39 precedenti con `formSections` + `fields[*].section` vengono migrate in memoria verso `formLayout` quando vengono caricate.

## Merge

`formLayout` viene sostituito atomicamente durante il merge della configurazione persistente. Questo evita che `array_replace_recursive()` conservi elementi numerici del layout di base quando una lista di campi viene accorciata o spostata.

## Test regressivo minimo

Il ciclo `build -> save -> load -> merge -> save -> load` deve mantenere invariati: ordine sezioni, proprieta sezione, ordine campi per sezione e lista `unsectioned`.
