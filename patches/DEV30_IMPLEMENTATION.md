# myCrudGpt 2.8.0-dev30 — Relational Create

Base prevista: `myCrudGpt_2.8.0_dev29_model_relation_aliases.zip`.

## Obiettivo

Consentire al form Create di una tabella parent di creare, in modo opt-in, uno o più record di relazioni `hasMany` nello stesso submit.

Scope dev30: **un solo livello parent -> children**. Nessuna creazione ricorsiva dei grandchildren.

## 1. ConfigBuilder

Estendere ogni voce `relationsConfig.hasMany` con:

```php
'create' => [
    'enabled' => false,
    'mode' => 'inline',
    'minRows' => 0,
    'maxRows' => 20,
    'fields' => [],
],
```

`enabled` deve essere `false` di default: lo schema prova l'esistenza della relazione, non l'intenzione applicativa di creare il figlio insieme al parent.

Quando si costruiscono i `fields` del child, copiare le stesse policy tecniche già usate dal parent e forzare non scrivibili:

- child primary key;
- `foreignKey` che punta al parent;
- `autoIncrement=true`;
- `databaseManaged=true` (dev27);
- eventuali campi esclusi dalla policy di form.

Il campo FK del parent non deve comparire tra i campi renderizzabili.

### POST Builder

Per ogni relazione:

```text
relationsConfig[hasMany][RELKEY][create][enabled]
relationsConfig[hasMany][RELKEY][create][mode]
relationsConfig[hasMany][RELKEY][create][minRows]
relationsConfig[hasMany][RELKEY][create][maxRows]
relationsConfig[hasMany][RELKEY][create][fields][]
```

Whitelist `mode`: per dev30 accettare solo `inline`.

## 2. Builder UI

Nella card delle relazioni hasMany aggiungere una sezione “Create relazionale”:

- checkbox `Abilita nel Create`;
- badge `1 livello`;
- `minRows`;
- `maxRows`;
- elenco campi child selezionabili.

I campi tecnici sopra indicati devono essere disabilitati e non postabili.

## 3. ViewGenerator

Nel Create passare alla view anche `relationalCreateConfig`.

Dopo `_form.php`, renderizzare una card per ogni `hasMany.create.enabled=true`.

Naming input obbligatorio:

```html
name="relations[RELKEY][0][FIELD]"
name="relations[RELKEY][1][FIELD]"
```

Aggiungere/rimuovere righe via JS clonando un `<template>`. Il server non deve fidarsi del contatore JS: `maxRows` è riapplicato dal `RelationalCreateProcessor`.

Non includere mai la FK del parent nel form figlio.

## 4. ControllerGenerator

Nel `store()`:

1. validare il parent con le regole esistenti;
2. sanificare il parent con `CrudInputProcessor`;
3. elaborare `relations` con `RelationalCreateProcessor`;
4. se ci sono errori child, `redirect()->back()->withInput()->with('errors', ...)`;
5. chiamare il Service con parent + relations.

Schema suggerito:

```php
$processor = new \App\Libraries\Crud\RelationalCreateProcessor();
$relational = $processor->prepare(
    $this->request->getPost(),
    $this->relationalCreateConfig()
);

if ($relational['errors'] !== []) {
    return redirect()->back()->withInput()->with('errors', $relational['errors']);
}

$this->service->create($data, $relational['relations']);
```

Il config passato deve contenere solo hasMany del CRUD corrente.

## 5. ModelGenerator

Aggiungere al Model parent un metodo generato che inserisce i children.

```php
public function insertRelationalChildren(
    int|string $parentId,
    array $relationsConfig,
    array $payload
): void {
    foreach ($payload as $relationKey => $rows) {
        $relation = $relationsConfig[$relationKey] ?? null;
        if (!is_array($relation) || empty($relation['create']['enabled'])) {
            continue;
        }

        $table = (string) $relation['childTable'];
        $foreignKey = (string) $relation['foreignKey'];
        $allowed = array_keys((array) ($relation['create']['fields'] ?? []));

        foreach ($rows as $row) {
            $clean = array_intersect_key((array) $row, array_flip($allowed));
            unset($clean[$relation['primaryKey']], $clean[$foreignKey]);

            // FK server-authoritative
            $clean[$foreignKey] = $parentId;

            if (!$this->db->table($table)->insert($clean)) {
                throw new \RuntimeException('Inserimento relazione figlia non riuscito: ' . $relationKey);
            }
        }
    }
}
```

La query rimane nel Model, non nel Controller.

## 6. ServiceGenerator

Cambiare la signature da:

```php
public function create(array $data)
```

a:

```php
public function create(array $data, array $relations = [])
```

Per Standard/Full usare una transazione unica:

```php
$db = db_connect();
$db->transException(true)->transStart();

try {
    $id = $this->model->insert($data, true);
    if ($id === false) {
        throw new \RuntimeException('Creazione record non riuscita.');
    }

    if ($relations !== []) {
        $this->model->insertRelationalChildren(
            $id,
            $this->relationalCreateConfig,
            $relations
        );
    }

    $db->transComplete();
    return $id;
} catch (\Throwable $e) {
    if ($db->transStatus()) {
        $db->transRollback();
    }
    throw $e;
}
```

Per Basic, dove non esiste Service, la stessa orchestrazione deve restare nel Controller ma le query child devono continuare a vivere nel Model.

## 7. Compatibilità dev27-dev29

Dev30 non deve modificare:

- `databaseManaged` e policy timestamp DB-managed (dev27);
- `relationNavigation.acceptContext` delle FK reali (dev28);
- alias belongsTo `<foreign_key>__label` (dev29).

Nel child form, `databaseManaged=true` resta non renderizzato e non scrivibile.

## 8. Test minimi

Aggiungere regression test:

- hasMany Create disabilitato di default;
- Builder persiste `create.enabled`, `minRows`, `maxRows`, fields;
- FK parent assente dal markup child;
- PK/autoincrement/databaseManaged assenti dal markup;
- payload con FK manipolata non può sovrascrivere la FK server-side;
- maxRows applicato server-side;
- fallimento di un child causa rollback del parent;
- relazione non configurata nel POST viene ignorata;
- dev27/dev28/dev29 continuano a passare.
