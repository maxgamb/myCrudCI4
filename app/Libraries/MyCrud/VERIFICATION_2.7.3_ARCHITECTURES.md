# Verifica myCrudGpt 2.7.3 — Basic, Standard e Full

Controlli eseguiti sul pacchetto:

- 122 file PHP dell'applicazione verificati con `php -l`;
- generazione sintetica delle tre architetture;
- 43 file PHP generati di prova verificati con `php -l`;
- Basic: Model, Validation, Controller, Views e Routes;
- Standard: Basic più Entity e Service;
- Full: Standard più API Controller, Resource, API Validation e OpenAPI;
- CSV e Word HTML presenti in tutte le architetture;
- nessuna route API in Basic e Standard;
- route API presenti solo in Full;
- Model Basic con `returnType = 'object'` e nessun import Entity;
- Model Standard e Full con Entity;
- Controller Basic collegato direttamente al Model;
- Controller Standard e Full collegato al Service;
- nessuna query SQL nei Controller e nei Service generati;
- OpenAPI YAML valida;
- nessun placeholder residuo nei file generati;
- import delle classi Validation verificati;
- output confinato in `app/Generated/` e protezione dal path traversal;
- layout `default_crud` per il generatore e `default_app` per le viste applicative.

La verifica è stata eseguita con una configurazione CRUD sintetica. Non sostituisce un test end-to-end con il database e l'intero progetto CodeIgniter 4 del destinatario.
