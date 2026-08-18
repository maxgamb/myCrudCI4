# myCrudCI4 2.9.1-dev24-fix11-fix43

## M2M Related Create contract final alignment

This fix changes generated tests only. Runtime Model, Service, Controller, API, Shield, Dashboard, and Builder behavior are unchanged.

The relational contract no longer requires the legacy generic `manyToManyRelatedCreateRelationOptions()` adapter. The current architecture is static and generation-time explicit: M2M option/read contracts are represented by `manyToManyFormOptions()`, `manyToManySelected()`, concrete relation methods and `relationRowsByIds()`. Related Create rules remain generated in the resource Rules class, while Service-enabled architectures validate concrete related Service references.

The generated contract now rejects `manyToManyRelatedCreateRelationOptions()` as a legacy generic adapter, preventing future regression toward runtime metadata dispatch.
