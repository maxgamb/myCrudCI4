<?php

declare(strict_types=1);

/**
 * myCrudCI4 persistent configuration for table store.
 *
 * Questo file contiene solo le scelte dello sviluppatore.
 * DB types, indexes, and relations are reread from the schema on every generation.
 */
return array (
  'table' => 'store',
  'architecture' => 'full',
  'order' => 
  array (
    0 => 'store_id',
    1 => 'manager_staff_id',
    2 => 'address_id',
    3 => 'last_update',
  ),
  'formSections' => 
  array (
  ),
  'fields' => 
  array (
    'store_id' => 
    array (
      'label' => '',
      'inputType' => 'number',
      'width' => 6,
      'section' => '',
      'relationMode' => '',
      'relationDisplayField' => '',
      'relationDisplayTemplate' => '',
      'relationNavigation' => 
      array (
        'quickFilter' => false,
        'parentLink' => false,
        'acceptContext' => false,
        'createParentLink' => false,
      ),
      'relationNavigationCustomized' => false,
      'relationCreate' => 
      array (
        'enabled' => false,
      ),
      'relationCreateCustomized' => false,
      'uiVisibilityCustomized' => true,
      'initialValue' => 
      array (
        'mode' => 'none',
        'custom' => '',
      ),
      'attributes' => 
      array (
        'boolean' => 
        array (
        ),
        'values' => 
        array (
        ),
      ),
      'ui' => 
      array (
        'searchable' => true,
        'sortable' => true,
        'visibleIndex' => true,
        'visibleForm' => true,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'exact',
        'mcpVisible' => true,
      ),
    ),
    'manager_staff_id' => 
    array (
      'label' => '',
      'inputType' => 'select',
      'width' => 6,
      'section' => '',
      'relationMode' => 'select',
      'relationDisplayField' => 'last_name',
      'relationDisplayTemplate' => '',
      'relationNavigation' => 
      array (
        'quickFilter' => true,
        'parentLink' => true,
        'acceptContext' => true,
        'createParentLink' => false,
      ),
      'relationNavigationCustomized' => true,
      'relationCreate' => 
      array (
        'enabled' => true,
      ),
      'relationCreateCustomized' => false,
      'uiVisibilityCustomized' => true,
      'initialValue' => 
      array (
        'mode' => 'none',
        'custom' => '',
      ),
      'attributes' => 
      array (
        'boolean' => 
        array (
          0 => 'required',
        ),
        'values' => 
        array (
        ),
      ),
      'ui' => 
      array (
        'searchable' => true,
        'sortable' => true,
        'visibleIndex' => true,
        'visibleForm' => true,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'exact',
        'mcpVisible' => true,
      ),
    ),
    'address_id' => 
    array (
      'label' => '',
      'inputType' => 'select',
      'width' => 6,
      'section' => '',
      'relationMode' => 'select',
      'relationDisplayField' => 'address',
      'relationDisplayTemplate' => '',
      'relationNavigation' => 
      array (
        'quickFilter' => true,
        'parentLink' => true,
        'acceptContext' => false,
        'createParentLink' => false,
      ),
      'relationNavigationCustomized' => true,
      'relationCreate' => 
      array (
        'enabled' => true,
      ),
      'relationCreateCustomized' => false,
      'uiVisibilityCustomized' => true,
      'initialValue' => 
      array (
        'mode' => 'none',
        'custom' => '',
      ),
      'attributes' => 
      array (
        'boolean' => 
        array (
          0 => 'required',
        ),
        'values' => 
        array (
        ),
      ),
      'ui' => 
      array (
        'searchable' => true,
        'sortable' => true,
        'visibleIndex' => true,
        'visibleForm' => true,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'exact',
        'mcpVisible' => true,
      ),
    ),
    'last_update' => 
    array (
      'label' => '',
      'inputType' => 'datetime-local',
      'width' => 6,
      'section' => '',
      'relationMode' => '',
      'relationDisplayField' => '',
      'relationDisplayTemplate' => '',
      'relationNavigation' => 
      array (
        'quickFilter' => false,
        'parentLink' => false,
        'acceptContext' => false,
        'createParentLink' => false,
      ),
      'relationNavigationCustomized' => false,
      'relationCreate' => 
      array (
        'enabled' => false,
      ),
      'relationCreateCustomized' => false,
      'uiVisibilityCustomized' => true,
      'initialValue' => 
      array (
        'mode' => 'none',
        'custom' => '',
      ),
      'attributes' => 
      array (
        'boolean' => 
        array (
        ),
        'values' => 
        array (
        ),
      ),
      'ui' => 
      array (
        'searchable' => false,
        'sortable' => false,
        'visibleIndex' => true,
        'visibleForm' => false,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'range',
        'mcpVisible' => true,
      ),
    ),
  ),
  'features' => 
  array (
    'relations' => true,
    'softDeletes' => false,
    'timestamps' => true,
  ),
  'apiCapabilities' => 
  array (
    'list' => true,
    'read' => true,
    'create' => true,
    'update' => true,
    'delete' => true,
    'trash' => false,
    'restore' => false,
    'forceDelete' => false,
  ),
  'crudSecurity' => 
  array (
    'auth' => 'none',
    'permissions' => 
    array (
      'list' => '',
      'read' => '',
      'create' => '',
      'update' => '',
      'delete' => '',
      'trash' => '',
      'restore' => '',
      'forceDelete' => '',
    ),
  ),
  'apiSecurity' => 
  array (
    'auth' => 'none',
    'permissions' => 
    array (
      'list' => '',
      'read' => '',
      'create' => '',
      'update' => '',
      'delete' => '',
      'trash' => '',
      'restore' => '',
      'forceDelete' => '',
      'upload' => '',
    ),
  ),
  'mcp' => 
  array (
    'enabled' => true,
    'transport' => 'stdio',
    'mode' => 'read_only',
    'serverName' => 'myCrudCI4',
    'security' => 
    array (
      'boundary' => 'local_process',
      'inheritsApiSecurity' => false,
      'remoteTransportAllowed' => false,
      'oauthRequiredForRemote' => true,
    ),
    'capabilities' => 
    array (
      'list' => true,
      'read' => true,
      'relations' => true,
    ),
  ),
  'relationsConfig' => 
  array (
    'hasMany' => 
    array (
      'customer__store_id' => 
      array (
        'enabled' => true,
        'title' => 'Customer',
        'icon' => 'bi-diagram-3',
        'limit' => 20,
        'showCount' => true,
        'showCreateButton' => true,
        'showViewAllButton' => true,
        'showViewButton' => true,
        'collapsible' => true,
        'collapsed' => false,
      ),
      'inventory__store_id' => 
      array (
        'enabled' => true,
        'title' => 'Inventory',
        'icon' => 'bi-diagram-3',
        'limit' => 20,
        'showCount' => true,
        'showCreateButton' => true,
        'showViewAllButton' => true,
        'showViewButton' => true,
        'collapsible' => true,
        'collapsed' => false,
      ),
      'staff__store_id' => 
      array (
        'enabled' => true,
        'title' => 'Staff',
        'icon' => 'bi-diagram-3',
        'limit' => 20,
        'showCount' => true,
        'showCreateButton' => true,
        'showViewAllButton' => true,
        'showViewButton' => true,
        'collapsible' => true,
        'collapsed' => false,
      ),
    ),
    'manyToMany' => 
    array (
    ),
  ),
  'list' => 
  array (
    'filtersSummary' => 'Filtri di ricerca',
  ),
  '_meta' => 
  array (
    'generatorVersion' => '2.9.1-dev24-fix11-fix48',
    'savedAt' => '2026-08-18T16:48:30+00:00',
    'schemaFingerprint' => 'eee593469dd6f440e4979c4711c748cc3dda92c44e30aa67e55ed8c974863a12',
    'configHash' => '3fbff1e496384dabaa792dae6b559e352081d3aa3f9a0c581feff91eba12c824',
  ),
);
