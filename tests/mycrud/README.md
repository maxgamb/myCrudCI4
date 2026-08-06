# Test e diagnostica myCrudGpt

## Controllo installazione

```bash
php spark mycrud:doctor
```

Report JSON:

```bash
php spark mycrud:doctor --json
php spark mycrud:doctor --report writable/mycrud-doctor.json
```

## Test di generazione

Il comando usa una tabella reale del database e prova le architetture Basic, Standard e Full:

```bash
php spark mycrud:test hotels
```

Senza sovrascrivere lo staging:

```bash
php spark mycrud:test hotels --no-force
```

Con report:

```bash
php spark mycrud:test hotels --report writable/mycrud-test-hotels.json
```

Il comando verifica anche:

- placeholder residui `{{...}}`;
- sintassi PHP dei file generati;
- presenza dei template richiesti;
- disponibilità di `BaseController.php`;
- scrivibilità della directory `Generated`.
