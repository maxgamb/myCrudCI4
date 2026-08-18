# myCrudGpt 2.8.0-dev36 — Service Extension Points

## Obiettivo

Separare in modo semplice il codice Service generato dalla logica applicativa custom.

Per ogni CRUD Standard/Full scrivibile vengono prodotti:

```text
app/Services/<Entity>Service.php
app/Services/Extensions/<Entity>ServiceExtension.php
```

`<Entity>Service.php` continua a passare dallo staging sicuro `app/Generated/Services/`. L'Extension invece viene creato **direttamente** in `app/Services/Extensions/` e non entra mai in `app/Generated/`.

## Regola di protezione

`<Entity>Service.php` è rigenerabile. `<Entity>ServiceExtension.php` è **create-only**: viene creato solo se manca e non viene mai sovrascritto, neppure con l'opzione di sovrascrittura attiva. Se esiste già in `app/Services/Extensions`, myCrudGpt lo lascia intatto. La cartella `app/Generated/` può quindi essere cancellata completamente senza perdere alcuna personalizzazione Service Extension.

## Hook disponibili

- `beforeCreate(array $data): array`
- `afterCreate(int|string $id, array $data): void`
- `beforeUpdate(int|string $id, array $data): array`
- `afterUpdate(int|string $id, array $data): void`
- `beforeDelete(int|string $id): void`
- `afterDelete(int|string $id): void`

Gli hook sono già presenti con implementazione neutra e commenti esplicativi.

## Responsabilità

Il Service generato continua a coordinare Model, transazioni e relazioni. L'Extension contiene esclusivamente logica applicativa custom. Le query SQL restano responsabilità del Model.
