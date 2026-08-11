<?php

declare(strict_types=1);

/**
 * Configurazione persistente myCrudGpt per la tabella payment.
 *
 * Questo file contiene solo le scelte dello sviluppatore.
 * Tipi DB, indici e relazioni vengono riletti dallo schema ad ogni generazione.
 */
return array (
  'table' => 'payment',
  'architecture' => 'full',
  'order' => 
  array (
    0 => 'payment_id',
    1 => 'customer_id',
    2 => 'staff_id',
    3 => 'rental_id',
    4 => 'amount',
    5 => 'payment_date',
    6 => 'last_update',
  ),
  'fields' => 
  array (
    'payment_id' => 
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
      'uiVisibilityCustomized' => true,
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
      ),
    ),
    'customer_id' => 
    array (
      'label' => '',
      'inputType' => 'select',
      'width' => 6,
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
      'uiVisibilityCustomized' => true,
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
      ),
    ),
    'staff_id' => 
    array (
      'label' => '',
      'inputType' => 'select',
      'width' => 6,
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
      'uiVisibilityCustomized' => true,
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
      ),
    ),
    'rental_id' => 
    array (
      'label' => '',
      'inputType' => 'select',
      'width' => 6,
      'relationMode' => 'select',
      'relationDisplayField' => 'rental_id',
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
      'uiVisibilityCustomized' => true,
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
      ),
    ),
    'amount' => 
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
      'uiVisibilityCustomized' => true,
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
        'visibleForm' => true,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'exact',
      ),
    ),
    'payment_date' => 
    array (
      'label' => '',
      'inputType' => 'datetime-local',
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
      'uiVisibilityCustomized' => true,
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
        'visibleForm' => true,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'range',
      ),
    ),
    'last_update' => 
    array (
      'label' => '',
      'inputType' => 'datetime-local',
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
      'uiVisibilityCustomized' => true,
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
    'generatorVersion' => '2.8.0-dev33',
    'savedAt' => '2026-08-10T17:56:16+00:00',
    'schemaFingerprint' => '8185d71a6515075aa286b8893aafea4512db626ffb2dfce296d8ff92f7b84d41',
    'configHash' => '771efefe2d480b2af905a0a9cf986c24bc807945d872d16882edef8da1837c8a',
  ),
);
