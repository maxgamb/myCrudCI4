<?php

declare(strict_types=1);

/**
 * myCrudCI4 persistent configuration for table actor.
 *
 * Questo file contiene solo le scelte dello sviluppatore.
 * DB types, indexes, and relations are reread from the schema on every generation.
 */
return array (
  'table' => 'actor',
  'architecture' => 'full',
  'order' => 
  array (
    0 => 'actor_id',
    1 => 'first_name',
    2 => 'last_name',
    3 => 'last_update',
  ),
  'formSections' => 
  array (
  ),
  'fields' => 
  array (
    'actor_id' => 
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
    'first_name' => 
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
          'maxlength' => '45',
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
        'filterMode' => 'prefix',
        'mcpVisible' => true,
      ),
    ),
    'last_name' => 
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
          'maxlength' => '45',
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
        'filterMode' => 'prefix',
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
      'relations' => false,
    ),
  ),
  'relationsConfig' => 
  array (
    'hasMany' => 
    array (
      'film_actor__actor_id' => 
      array (
        'enabled' => true,
        'title' => 'Film Actor',
        'icon' => 'bi-diagram-3',
        'limit' => 20,
        'showCount' => true,
        'showCreateButton' => true,
        'showViewAllButton' => true,
        'showViewButton' => false,
        'collapsible' => true,
        'collapsed' => false,
      ),
    ),
    'manyToMany' => 
    array (
      'many__film_actor__actor_id' => 
      array (
        'enabled' => true,
        'title' => 'Film',
        'icon' => 'bi-diagram-2',
        'limit' => 20,
        'showCount' => true,
        'showViewButton' => true,
        'createEnabled' => true,
        'editEnabled' => true,
        'createRelatedEnabled' => true,
        'createRelatedCustomized' => true,
        'collapsible' => true,
        'collapsed' => false,
        'formWidth' => 6,
      ),
    ),
  ),
  'list' => 
  array (
    'filtersSummary' => 'Filtri di ricerca',
  ),
  '_meta' => 
  array (
    'generatorVersion' => '2.9.1-dev24-fix11-fix48',
    'savedAt' => '2026-08-18T16:48:29+00:00',
    'schemaFingerprint' => 'd03180dd8c04cb97bc614aaa86ffbbbf780868ea408403d16fcfada4ef0ea24e',
    'configHash' => '3559be30a7ad5ecc835f13209522d518e7e712a50d868b448557ce330e0fe721',
  ),
);
