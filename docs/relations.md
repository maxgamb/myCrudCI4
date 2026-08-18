# Relations

myCrudCI4 reads foreign-key metadata from the database and uses it to scaffold navigation and related-record behavior.

## Belongs-to

A real foreign key can provide:

- display labels instead of raw IDs;
- parent record navigation;
- context-aware Create;
- relation options;
- relational Create.

For large relation tables, the Builder can use AJAX-backed lookup instead of rendering very large `<select>` elements.

## Has-many

Has-many relations can be scaffolded on the parent detail view with options such as:

- relation title;
- count;
- create button;
- view-all button;
- row limit;
- collapsible display.

## Many-to-many

Pure pivot tables can be detected and scaffolded as many-to-many relations.

The standard generated selector supports:

- local search;
- checkboxes;
- selected-item badges;
- Create/Edit synchronization;
- server-side validation of selected IDs.

Enriched pivots with application-specific columns are intentionally treated more conservatively.

## Cascaded navigation

Navigation context can be preserved across parent/child workflows so generated CRUD pages can return users to the relevant record context.

## Database authority

Relations are rediscovered from the current database schema when a CRUD is regenerated. Persistent configuration stores only developer choices applied to those relations.
