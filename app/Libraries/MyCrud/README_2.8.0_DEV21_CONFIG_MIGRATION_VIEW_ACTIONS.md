# myCrudGpt 2.8.0-dev21 — config migration + view actions

Consolidamento successivo ai test Sakila della dev20.

- Il merge delle configurazioni persistenti conserva soltanto le proprieta realmente configurabili dei campi; schema, tipi, indici, FK e policy tecniche restano autorevoli dal DB corrente.
- Le configurazioni hasMany precedenti alla dev20 migrano automaticamente al set colonne dello schema corrente, evitando duplicazioni dovute ad `array_replace_recursive()` su array indicizzati.
- Dalla dev21 in poi, una selezione colonne hasMany salvata viene trattata come lista atomica e validata contro le colonne correnti. Le config dev20 vengono migrate perché potevano essere state risalvate dopo il merge difettoso.
- `childRecordDetail` resta autorevole dallo schema: `showViewButton` viene sempre disattivato per VIEW, PK composte o child senza dettaglio sicuro.
- Le policy spatial vengono riapplicate dal tipo DB corrente e non possono essere riabilitate da snapshot legacy.
- Nella view di dettaglio, accanto a `Stampa`, vengono generati `Modifica` e `Cancella` soltanto per CRUD writable. La cancellazione resta POST + CSRF + conferma JS.
