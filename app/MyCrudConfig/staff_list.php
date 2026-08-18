<?php

declare(strict_types=1);

/**
 * myCrudCI4 persistent configuration for table staff_list.
 *
 * Questo file contiene solo le scelte dello sviluppatore.
 * DB types, indexes, and relations are reread from the schema on every generation.
 */
return array (
  'table' => 'staff_list',
  'architecture' => 'full',
  'order' => 
  array (
    0 => 'ID',
    1 => 'name',
    2 => 'address',
    3 => 'zip code',
    4 => 'phone',
    5 => 'city',
    6 => 'country',
    7 => 'SID',
  ),
  'formSections' => 
  array (
  ),
  'fields' => 
  array (
    'ID' => 
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
      'uiVisibilityCustomized' => false,
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
        'filterMode' => 'exact',
        'mcpVisible' => true,
      ),
    ),
    'name' => 
    array (
      'label' => '',
      'inputType' => 'text',
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
      'uiVisibilityCustomized' => false,
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
          'maxlength' => '91',
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
        'filterMode' => 'prefix',
        'mcpVisible' => true,
      ),
    ),
    'address' => 
    array (
      'label' => '',
      'inputType' => 'text',
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
      'uiVisibilityCustomized' => false,
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
          'maxlength' => '50',
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
        'filterMode' => 'prefix',
        'mcpVisible' => true,
      ),
    ),
    'zip code' => 
    array (
      'label' => '',
      'inputType' => 'text',
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
      'uiVisibilityCustomized' => false,
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
          'maxlength' => '10',
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
        'filterMode' => 'prefix',
        'mcpVisible' => true,
      ),
    ),
    'phone' => 
    array (
      'label' => '',
      'inputType' => 'text',
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
      'uiVisibilityCustomized' => false,
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
          'maxlength' => '20',
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
        'filterMode' => 'prefix',
        'mcpVisible' => true,
      ),
    ),
    'city' => 
    array (
      'label' => '',
      'inputType' => 'text',
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
      'uiVisibilityCustomized' => false,
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
          'maxlength' => '50',
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
        'filterMode' => 'prefix',
        'mcpVisible' => true,
      ),
    ),
    'country' => 
    array (
      'label' => '',
      'inputType' => 'text',
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
      'uiVisibilityCustomized' => false,
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
          'maxlength' => '50',
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
        'filterMode' => 'prefix',
        'mcpVisible' => true,
      ),
    ),
    'SID' => 
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
      'uiVisibilityCustomized' => false,
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
        'searchable' => false,
        'sortable' => false,
        'visibleIndex' => true,
        'visibleForm' => false,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'exact',
        'mcpVisible' => true,
      ),
    ),
  ),
  'features' => 
  array (
    'relations' => false,
    'softDeletes' => false,
    'timestamps' => true,
  ),
  'apiCapabilities' => 
  array (
    'list' => true,
    'read' => false,
    'create' => false,
    'update' => false,
    'delete' => false,
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
    'enabled' => false,
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
      'read' => false,
      'relations' => false,
    ),
  ),
  'relationsConfig' => 
  array (
    'hasMany' => 
    array (
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
    'schemaFingerprint' => 'e1f49f9fc7d3483a303b030246eda030a0618f758caaaa598e0e223b30e01009',
    'configHash' => 'b74edd9009c4806820fb0a07a8b6a41706be449af64b67ae5f72889a147be169',
  ),
);
