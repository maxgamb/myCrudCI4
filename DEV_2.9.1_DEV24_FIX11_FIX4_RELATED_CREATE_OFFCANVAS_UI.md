# myCrudCI4 2.9.1-dev24-fix11-fix4

## Related Create Offcanvas UI

This fix changes only the presentation of many-to-many Related Create. The persistence payload, validation, Service orchestration, transaction boundary and pivot synchronization remain unchanged.

### Previous UI

The complete target Create form was rendered directly inside the M2M card under a switch. Large targets such as `film` made parent forms very tall and visually confusing even when inline creation was not active.

### New UI

The M2M card remains compact and shows a `Create new <Target>` action. The target fields are presented in a Bootstrap offcanvas only when the action is requested. `Apply new <Target>` keeps the nested payload active for the main form submission, while Cancel/X disables it. A compact ready badge and Remove action make the pending inline creation visible without expanding the card.

### Contract

- existing record selection remains unchanged;
- `_many_new[...]` and `_many_related[...]` keep their existing server contract;
- nested fields are disabled unless the new target payload is active;
- validation failures reopen the offcanvas;
- no Model, Service or database behavior changes;
- M2M Related Create remains transactional with the main CRUD write.

### Regression guard

The architecture regression runner now requires the generated M2M form to contain the offcanvas UI and rejects the old `data-many-related-toggle` switch pattern.
