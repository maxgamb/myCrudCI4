# myCrudCI4 2.9.1-dev24-fix11-fix2 — Related Create Model Adapter

Bugfix della fix11-fix1.

## Problema

Quando una FK aveva `relationCreate.enabled=true`, il Controller generato chiamava sempre
`$this->model->relatedCreateRelationOptions()`. Il ModelGenerator, invece, emetteva quel
metodo solo se il record padre da creare inline conteneva a sua volta almeno una FK
`select` da popolare.

Per parent semplici come `language` il metodo non veniva quindi generato, causando:

`Call to undefined method App\\Models\\FilmModel::relatedCreateRelationOptions`

## Correzione

Se Related Create è abilitato per almeno una FK, il Model espone sempre
`relatedCreateRelationOptions()`. Se il parent non possiede FK annidate compatibili,
il metodo restituisce semplicemente `[]`.

La correzione non modifica BaseCrudModel, Service, transazioni o ownership delle query.
