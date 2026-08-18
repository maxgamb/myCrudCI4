# myCrudGpt 2.8.0-dev39 fix3 — Persistence fix

- Corretto `CrudConfigRepository::toPersistentConfig()`: ora persiste `formSections`.
- Ogni campo persiste `section`, quindi l’assegnazione campo → sezione sopravvive a save/reload/merge.
- Le policy `upload` dev39 vengono persistite insieme alla configurazione del campo.
- Il fix non modifica la semantica schema-authoritative: tipi DB, FK, indici e metadati tecnici continuano a derivare dallo schema.
