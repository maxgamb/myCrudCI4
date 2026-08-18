# myCrudGpt 2.8.0-dev39 — Form Sections, Uploads & Extension UX

## Obiettivo
Migliorare la leggibilità dei form generati e offrire upload semplici senza trasformare myCrudGpt in un file manager.

## Form Sections
- sezioni configurabili con titolo, icona, gutter e stato collassabile;
- drag & drop dei campi tra sezioni;
- larghezza campo 1–12 indipendente dal gutter;
- preview Builder coerente con il layout generato.

## Upload
- input `file` e `image`;
- percorso relativo salvato nel DB;
- `CrudFileUploader` condiviso;
- whitelist estensioni, max KB, nome sicuro, replace/remove;
- preview immagine/link file in Edit;
- replace/remove aggiornano il riferimento DB; il cleanup fisico dei vecchi file resta un Extension Point applicativo per evitare cancellazioni prima del commit.

## Extension UX
Il Builder Standard/Full mostra il percorso persistente `app/Services/Extensions/<Entity>ServiceExtension.php` e i sei hook CRUD disponibili.

## Non incluso
Crop, thumbnail, gallery multiple, cloud storage, BLOB, virus scanning.

## fix1 UI — gestione sezioni

- ogni sezione utente ha un handle dedicato `bi-grip-vertical` per il drag;
- sono disponibili anche i pulsanti `Sposta su`, `Sposta giù` ed `Elimina`;
- eliminando una sezione i campi non vengono cancellati: passano in `Senza sezione`;
- `Senza sezione` è una zona di sistema persistente per i campi non assegnati e non viene resa come card nel form finale;
- le aree di drop vengono evidenziate durante il trascinamento dei campi;
- il drag dell'intera card è disabilitato: il riordino parte solo dall'handle dedicato.
