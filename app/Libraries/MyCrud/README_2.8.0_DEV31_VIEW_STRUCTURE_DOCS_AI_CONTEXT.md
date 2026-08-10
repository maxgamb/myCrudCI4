# myCrudGpt 2.8.0-dev31 — View Structure, Builder Docs, AI Context

Base: `2.8.0-dev30` revisionata.

## 1. Struttura uniforme delle viste CRUD

Le viste principali generate (`index`, `create`, `edit`, `detail`, `trash`) adottano una gerarchia UI comune:

```text
Breadcrumb Bootstrap
Nome tabella (h1)
Contesto pagina (small.text-muted)
Toolbar
Contenuto / card
```

Il nome della tabella resta l'unico `h1` della pagina. I titoli interni delle card form/dettaglio usano `h2`.

Contesti previsti:

- Index: `Elenco`
- Create: `Nuovo record`
- Edit: `Modifica record`
- Detail: `Dettaglio record`
- Trash: `Cestino`

Il breadcrumb conserva il `navigationContext` nelle viste che già lo supportano.

## 2. Documentazione Builder

`app/Views/mycrud/docs.php` include una nuova sezione **Guida ai campi del Builder** che documenta:

- tipo input;
- caricamento FK con select completa o AJAX;
- valore descrittivo e template descrittivo;
- label e larghezza Bootstrap;
- filtro rapido, link padre, context URL e link Nuovo padre;
- Relational Create `Seleziona oppure crea nuovo`;
- `required`, `readonly`, `disabled`;
- searchable, sortable, visibilità Index/Form/View, sensitive, export, API;
- attributi HTML `max`, `step`, `pattern`, `placeholder`.

La documentazione evidenzia che Relational Create salva padre e record corrente nella stessa transazione e che la PK generata dal padre viene imposta server-side come FK.

## 3. AI Context aggiornato

`AiProjectContextGenerator` espone ora esplicitamente:

- struttura delle viste CRUD;
- regola del singolo `h1` di pagina;
- breadcrumb Bootstrap;
- small di contesto pagina;
- heading interni `h2`;
- semantica e sicurezza del Relational Create;
- transazione padre + record corrente;
- FK derivata esclusivamente dalla PK padre generata server-side.

Le informazioni sono riportate in:

```text
AI_PROJECT_CONTEXT.md
docs/ai/project.json
docs/ai/crud/<table>.md
```

## Compatibilità

La dev31 non modifica lo schema DB e non cambia i nomi dei campi. Mantiene le convenzioni di dev27-dev30, incluse le policy `databaseManaged`, `acceptContext`, alias relazionali `__label` e Relational Create.


## fix3 — Relational Create vs Nuovo padre

Quando `relationCreate.enabled=true`, `relationNavigation.createParentLink` viene normalizzato a `false`. Il Builder disattiva dinamicamente la checkbox “Link Nuovo padre” e la riabilita solo se Relational Create viene spento. Questo evita di lasciare il Create corrente e perdere dati non ancora salvati. La regola è applicata anche server-side alle configurazioni persistenti precedenti.

## fix4 — Relational Create partial dedicato

Quando `relationCreate.enabled=true`, il Create mostra il comando `Crea nuovo <Parent>` tramite Bootstrap Offcanvas sovrapposto alla vista. L’Offcanvas non modifica il layout del form principale e non incorpora la pagina `create.php` del padre: il generatore produce nel CRUD corrente un partial dedicato per ogni FK, ad esempio `Views/city/_related_create_country_id.php`, contenente esclusivamente i campi scrivibili del parent ricavati dallo schema. In questo modo non vengono annidati breadcrumb, `h1`, toolbar, submit o `<form>` del CRUD padre.

Il partial dedicato mantiene separata la configurazione del form principale dalla creazione embedded del parent. La creazione del parent e del record corrente resta atomica nella stessa transazione e la FK è sempre imposta dalla PK generata lato server.



## fix5 — Relational Create Offcanvas sovrapposto

La UI del Relational Create usa ora un Bootstrap Offcanvas `offcanvas-end`. Il pannello viene sovrapposto alla vista corrente e non modifica il layout del form principale. La select FK originaria resta visivamente invariata. All'apertura dell'Offcanvas `_related_new[<fk>]` passa a `1` e vengono abilitati solo i campi `_related[...]` del partial; alla chiusura/annullamento torna a `0` e i campi embedded vengono disabilitati. In caso di errori server-side sul nuovo parent, l'Offcanvas viene riaperto automaticamente tramite `old('_related_new')`. Non esiste un submit del parent: il salvataggio avviene esclusivamente con il submit del form principale e resta transazionale.

## fix6 — FK input-group + icone

Per le FK standard (select completa), il controllo e le azioni correlate vengono ora renderizzati nello stesso Bootstrap `input-group`: la select resta il controllo principale, “Apri padre” usa il bottone `btn-outline-secondary` con icona `bi-box-arrow-up-right`, mentre Relational Create usa `bi-plus-circle` + testo breve `Nuovo` e apre l’Offcanvas introdotto in fix5. Il vecchio pulsante Relational Create separato sotto il campo è stato eliminato. Le FK AJAX mantengono invece il widget search/results e mostrano le azioni subito sotto per non rompere la struttura del componente di ricerca.


## Stato finale — STABLE

La linea `2.8.0-dev31` viene consolidata come **STABLE** dopo la fix6.

Consolidamento finale:

- breadcrumb + unico `h1` nelle viste CRUD;
- documentazione Builder estesa;
- AI Project Context aggiornato alle convenzioni strutturali correnti;
- Relational Create con partial dedicato, Offcanvas Bootstrap e submit unico transazionale;
- azioni FK standard raccolte in `input-group` (`Apri padre` con icona, `Nuovo` con icona + testo);
- `createParentLink` normalizzato a `false` quando `relationCreate.enabled=true`;
- mantenuti i fix dev27 `databaseManaged`, dev28 `acceptContext` e dev29 alias `__label`;
- cleanup finale della formattazione HTML generata.

Non vengono introdotte nuove funzionalità in questo consolidamento. Le evoluzioni successive (Relational Edit, hasMany, pivot/many-to-many e navigazione a cascata) restano fuori dallo scope della dev31 stabile.
