# Installazione aggiornamento 2.2

Unire la cartella `app/` con la baseline corrente senza cancellare i file applicativi esistenti.

File nuovi principali:

```text
app/Commands/MyCrudDoctor.php
app/Commands/MyCrudTest.php
app/Libraries/MyCrud/Diagnostics/
```

Dopo la copia:

```bash
composer dump-autoload
php spark cache:clear
php spark mycrud:doctor
php spark mycrud:test hotels
```

Sostituire `hotels` con una tabella reale del proprio database.
