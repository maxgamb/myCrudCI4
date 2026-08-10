# myCrudGpt 2.8.0-dev14 - Consolidation Candidate

Passaggio di consolidamento prima del collaudo con il database MySQL Sakila.

## Correzioni consolidate

- Quick: schema sempre dal DB, ma riutilizza le configurazioni persistenti esistenti.
- Quick: i default FK neutri vengono applicati solo alle FK non ancora configurate.
- La scelta Basic/Standard/Full effettuata nella Quick resta esplicita e prevale sull'architettura salvata.
- Menu Builder: aggiunto salvataggio esplicito della configurazione in `app/MyCrudConfig/Project/Menu.php`.
- Menu Builder: riapre la configurazione salvata; nuove tabelle DB restano non assegnate.
- Menu Builder: `Genera Menu` continua a scrivere esclusivamente in `app/Generated/`.
- Project Doctor: chiarito in UI che controlla DB + MyCrudConfig, non `app/` o `app/Generated/`.
- Documentazione aggiornata ai comportamenti consolidati.

## Prossimo passo

Collaudo reale su Sakila prima di dichiarare la 2.8 stabile.
