# myCrudGpt 2.8.0-dev39 fix2 UI

Correzione della gestione Sezioni del form.

- Ogni campo espone `Sezione form` oltre al drag&drop.
- Il select e il drag&drop sono sincronizzati bidirezionalmente.
- La creazione/assegnazione delle sezioni non dipende da SortableJS.
- Aggiunta sezione non genera errori JavaScript se SortableJS non è disponibile.
- Eliminando una sezione, i campi restano in `Senza sezione`.
- Le sezioni vuote non vengono renderizzate nel form finale: una sezione compare quando contiene almeno un campo.
