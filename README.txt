myCrudGpt 2.8.0-dev30 - Relational Create PATCH KIT

Questo archivio NON sostituisce la dev29 completa: contiene il nuovo runtime RelationalCreateProcessor e le specifiche/frammenti di integrazione da applicare sopra myCrudGpt_2.8.0_dev29_model_relation_aliases.zip.

Motivo: l'archivio dev29 di riferimento è presente nello storico del progetto ma non è esposto in questa sessione come file filesystem modificabile. Evitare di sovrascrivere i generatori con vecchie copie recuperate dalla libreria, perché si perderebbero dev27-dev29.

File principale nuovo:
app/Generated/Libraries/Crud/RelationalCreateProcessor.php

Specifiche:
patches/DEV30_IMPLEMENTATION.md
patches/VIEW_INLINE_TEMPLATE.php.txt

test smoke:
tests/RelationalCreateProcessorSmoke.php

Per ottenere il pacchetto dev30 completo e già fuso, applicare queste modifiche alla dev29 corrente mantenendo le policy dev27-dev29.
