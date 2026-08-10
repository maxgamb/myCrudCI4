<?php

declare(strict_types=1);

/**
 * Configurazione persistente myCrudGpt per la tabella nicer_but_slower_film_list.
 *
 * Questo file contiene solo le scelte dello sviluppatore.
 * Tipi DB, indici e relazioni vengono riletti dallo schema ad ogni generazione.
 */
return array (
  'table' => 'nicer_but_slower_film_list',
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
  'fields' => 
  array (
    'FID' => 
    array (
      'label' => '',
      'inputType' => 'number',
      'width' => 6,
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
      'uiVisibilityCustomized' => false,
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
        'filterMode' => 'exact',
      ),
    ),
    'title' => 
    array (
      'label' => '',
      'inputType' => 'text',
      'width' => 6,
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
      'uiVisibilityCustomized' => false,
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
        'visibleForm' => true,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'prefix',
      ),
    ),
    'description' => 
    array (
      'label' => '',
      'inputType' => 'textarea',
      'width' => 6,
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
      'uiVisibilityCustomized' => false,
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
        'visibleForm' => true,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'prefix',
      ),
    ),
    'category' => 
    array (
      'label' => '',
      'inputType' => 'text',
      'width' => 6,
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
      'uiVisibilityCustomized' => false,
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
        'visibleForm' => true,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'prefix',
      ),
    ),
    'price' => 
    array (
      'label' => '',
      'inputType' => 'number',
      'width' => 6,
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
      'uiVisibilityCustomized' => false,
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
        'filterMode' => 'exact',
      ),
    ),
    'length' => 
    array (
      'label' => '',
      'inputType' => 'number',
      'width' => 6,
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
      'uiVisibilityCustomized' => false,
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
        'filterMode' => 'exact',
      ),
    ),
    'rating' => 
    array (
      'label' => '',
      'inputType' => 'text',
      'width' => 6,
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
      'uiVisibilityCustomized' => false,
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
        'visibleForm' => true,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'prefix',
      ),
    ),
    'actors' => 
    array (
      'label' => '',
      'inputType' => 'textarea',
      'width' => 6,
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
      'uiVisibilityCustomized' => false,
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
        'visibleForm' => true,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'prefix',
      ),
    ),
  ),
  'features' => 
  array (
    'relations' => true,
    'softDeletes' => false,
    'timestamps' => true,
  ),
  'relationsConfig' => 
  array (
    'hasMany' => 
    array (
    ),
  ),
  'list' => 
  array (
    'filtersSummary' => 'Filtri di ricerca',
  ),
  '_meta' => 
  array (
    'generatorVersion' => '2.8.0-dev31',
    'savedAt' => '2026-08-10T15:05:47+00:00',
    'schemaFingerprint' => '23379388c77f4e1912828bb423d260c1bb8ba6b8257bcf3297ef2e3805c0a288',
    'configHash' => 'b6662e0ff01332dd401efd539ae09557a019b427240bee78776cade6a9328801',
  ),
);
