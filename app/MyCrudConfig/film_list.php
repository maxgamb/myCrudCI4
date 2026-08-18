<?php

declare(strict_types=1);

/**
 * myCrudCI4 persistent configuration for table film_list.
 *
 * Questo file contiene solo le scelte dello sviluppatore.
 * DB types, indexes, and relations are reread from the schema on every generation.
 */
return array (
  'table' => 'film_list',
  'architecture' => 'full',
  'order' => 
  array (
    0 => 'FID',
    1 => 'title',
    2 => 'description',
    3 => 'category',
    4 => 'price',
    5 => 'length',
    6 => 'rating',
    7 => 'actors',
  ),
  'formSections' => 
  array (
  ),
  'fields' => 
  array (
    'FID' => 
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
    'title' => 
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
          'maxlength' => '128',
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
    'description' => 
    array (
      'label' => '',
      'inputType' => 'textarea',
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
          'maxlength' => '65535',
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
    'category' => 
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
          'maxlength' => '25',
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
    'price' => 
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
    'length' => 
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
    'rating' => 
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
          'maxlength' => '5',
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
    'actors' => 
    array (
      'label' => '',
      'inputType' => 'textarea',
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
          'maxlength' => '65535',
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
    'schemaFingerprint' => '2b01d8cabb0b68bdec0b685900f343e3970a9832ed69cc8fcaac2800937005a0',
    'configHash' => '6d438c4610894d6317a003aaa4377c6c4e181ea182883150e82c7591cf2bb024',
  ),
);
