# myCrudGpt 2.8.0-dev13 - Global Parent Tables

Correzione additiva della dev12.

- Base: dev11.
- Nessun blocco esistente del Builder viene rimosso.
- In `mycrud/builder/configure/<tabella>` viene aggiunta una sidebar verticale.
- La sidebar contiene tutte le tabelle del database che sono destinazione di almeno una FK.
- Le tabelle sono deduplicate, ordinate e limitate a quelle configurabili dal Builder.
- Ogni voce punta a `/mycrud/builder/configure/<tabella_padre>`.
- La navigazione relazioni esistente (padri / tabella corrente / figli) resta invariata.
