<?php

declare(strict_types=1);

/**
 * myCrudCI4 persistent configuration for table rental.
 *
 * Questo file contiene solo le scelte dello sviluppatore.
 * DB types, indexes, and relations are reread from the schema on every generation.
 */
return array (
  'table' => 'rental',
  'architecture' => 'full',
  'order' => 
  array (
    0 => 'rental_id',
    1 => 'rental_date',
    2 => 'inventory_id',
    3 => 'customer_id',
    4 => 'return_date',
    5 => 'staff_id',
    6 => 'last_update',
  ),
  'formSections' => 
  array (
  ),
  'fields' => 
  array (
    'rental_id' => 
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
    'rental_date' => 
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
        'mode' => 'now',
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
    'inventory_id' => 
    array (
      'label' => '',
      'inputType' => 'select',
      'width' => 6,
      'section' => '',
      'relationMode' => 'select',
      'relationDisplayField' => 'inventory_id',
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
    'customer_id' => 
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
    'return_date' => 
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
        'mode' => 'now',
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
        'visibleForm' => true,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'range',
        'mcpVisible' => true,
      ),
    ),
    'staff_id' => 
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
      'payment__rental_id' => 
      array (
        'enabled' => true,
        'title' => 'Payment',
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
    'schemaFingerprint' => 'd5f022f999cbcd79bb0c52c3c39927e4e954e416be7061c7ac29751abe12ffa1',
    'configHash' => '77ac3e6eebf8ebc79fd386fae01a4be3827cb2298f3021b0ce6116a2e20a8fed',
  ),
);
