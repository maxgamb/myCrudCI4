# myCrudCI4 2.9.1-dev2-fix8 — Pure-pivot hasMany override

For pure pivot tables such as Sakila `film_actor` and `film_category`, hasMany
remains disabled by default because a many-to-many relation is available.

An explicit Builder enable is now preserved instead of being forced back to
false by `ConfigBuilder::finalize()`.

Normal hasMany relations such as `inventory` are unchanged.
