# myCrudGpt 2.8.0-dev35 STABLE — Cascaded Navigation

Base: dev34 STABLE.

## Obiettivo

Trasformare la navigazione parent/child introdotta in dev33 in una catena contestuale multi-livello, senza form ricorsivi. Esempio: Hotel → Prenotazione → Conto → Pagamento.

## Regole

- `_trail` contiene esclusivamente il percorso UI (table, id, label) ed è codificato base64url JSON.
- `_trail` non autorizza mai scritture e non viene usato per determinare FK.
- la FK del parent continua a passare tramite il normale context schema-whitelisted (`_parent_field` + FK reale).
- breadcrumb Create/Edit/View mostrano gli antenati del percorso.
- i link hasMany `Nuovo`, `Vedi tutti` e `Dettaglio` propagano il trail aggiungendo il record corrente.
- il Create figlio, dopo Salva/Annulla, torna al parent diretto conservando gli antenati.
- profondità massima trail: 8 segmenti; nessuna ricorsione di form o salvataggio.

## Runtime

Viene generato `App\Libraries\Crud\CrudNavigationTrail` come helper runtime condiviso.

## Impalcatura, non workflow engine

La dev35 non genera wizard né form annidati. Propaga solo il percorso di navigazione; ogni CRUD resta autonomo e modificabile manualmente.


## Fix1 — breadcrumb e link relazionali

- Propagazione `_trail` anche nei link `belongsTo` / “Apri padre” e nelle azioni contestuali.
- I link al padre già presente come ultimo segmento tornano agli antenati, evitando duplicazioni nel breadcrumb.
- I nuovi segmenti generati dagli hasMany/N:N preferiscono una label descrittiva del record: `first_name + last_name`, `nome + cognome`, `name/title/...`, con fallback `Tabella #ID`.
- `_trail` resta esclusivamente contesto UI: non autorizza scritture e non sostituisce la validazione FK.


## Stato STABLE
La release stabile include la fix1: propagazione `_trail` anche sui link belongsTo / Apri padre e breadcrumb con label descrittive quando disponibili.
