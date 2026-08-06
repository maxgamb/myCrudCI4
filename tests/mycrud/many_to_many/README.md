# Test many-to-many semplice

1. Eseguire `schema.sql` su un database di test.
2. Aprire `mycrud/builder/configure/test_users`.
3. Verificare il pannello many-to-many verso `test_roles`.
4. Generare il CRUD in Basic, Standard e Full.
5. Verificare create/edit: selezione multipla e sincronizzazione della pivot.
6. Eseguire `php spark mycrud:test test_users` e `php spark mycrud:doctor`.

La tabella pivot con campi business aggiuntivi non deve essere classificata come pivot semplice.
