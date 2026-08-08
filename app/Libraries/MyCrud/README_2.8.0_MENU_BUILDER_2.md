# myCrudGpt 2.8.0-dev6 — Menu Builder 2

La dev6 migliora esclusivamente la navigazione generata senza modificare il motore CRUD 2.8 già validato.

## Suggerimenti di aggregazione

Il Menu Builder combina:

- foreign key padre/figlio;
- prefissi ricorrenti (`ref_*`, `log_*`, `obmp_*`, ecc.);
- secondo prefisso ricorrente per proporre un sottogruppo;
- fallback `Principale`.

I suggerimenti non sono vincolanti: lo sviluppatore può rinominare o spostare ogni voce.

## Gerarchia

Il menu supporta massimo tre livelli visuali:

1. gruppo;
2. sottogruppo;
3. voce CRUD.

La tabella e i campi DB non vengono rinominati: label e struttura riguardano solo la navigazione.

## Builder

- drag & drop delle voci tra gruppi e sottogruppi;
- creazione di gruppi, sottogruppi e voci manuali;
- riordino gruppi;
- label, route, icona e visibilità modificabili;
- preferiti opzionali;
- filtro istantaneo delle oltre 100 tabelle;
- anteprima verticale e orizzontale;
- ripristino dei suggerimenti DB ricaricando il tool.

## Runtime generato

`Config/Menu.php` contiene una sola struttura dati e i due renderer la riutilizzano.

### Verticale

- sidebar Bootstrap;
- accordion gruppi;
- collapse sottogruppi;
- gruppo corrente aperto;
- route corrente evidenziata;
- ricerca client-side senza query DB;
- sezione Preferiti.

### Orizzontale

- navbar/dropdown Bootstrap;
- sottogruppi come intestazioni nei dropdown;
- Preferiti;
- ricerca client-side tramite dropdown dedicato.

Tutti i file vengono prodotti esclusivamente sotto `app/Generated/`.
