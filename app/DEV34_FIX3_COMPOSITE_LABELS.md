# myCrudGpt 2.8.0-dev34 fix3 — Many-to-Many composite labels

Correzione UX delle opzioni N:N.

- Il valore tecnico resta sempre la PK target.
- La label viene composta automaticamente quando il target espone campi descrittivi complementari.
- Caso Sakila `actor`: `first_name + last_name`, evitando voci apparentemente duplicate come `ADAM`, `ALBERT`.
- Caso `category`: resta il singolo campo `name`.
- La composizione deriva dallo schema tramite `RelationResolver`; non viene persistita come scelta utente.
