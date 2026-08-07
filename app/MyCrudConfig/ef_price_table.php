<?php

declare(strict_types=1);

/**
 * Configurazione persistente myCrudGpt per la tabella ef_price_table.
 *
 * Questo file contiene solo le scelte dello sviluppatore.
 * Tipi DB, indici e relazioni vengono riletti dallo schema ad ogni generazione.
 */
return array (
  'table' => 'ef_price_table',
  'architecture' => 'full',
  'order' => 
  array (
    0 => 'price_ef_is',
    1 => 'hotel_id',
    2 => 'from',
    3 => 'to',
    4 => 'single',
    5 => 'single_plus',
    6 => 'tw_db',
    7 => 'student',
    8 => 'fam_tr',
  ),
  'fields' => 
  array (
    'price_ef_is' => 
    array (
      'label' => '',
      'inputType' => 'number',
      'width' => 6,
      'relationMode' => '',
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
    'hotel_id' => 
    array (
      'label' => '',
      'inputType' => 'number',
      'width' => 6,
      'relationMode' => '',
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
    'from' => 
    array (
      'label' => '',
      'inputType' => 'date',
      'width' => 6,
      'relationMode' => '',
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
        'filterMode' => 'range',
      ),
    ),
    'to' => 
    array (
      'label' => '',
      'inputType' => 'date',
      'width' => 6,
      'relationMode' => '',
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
        'filterMode' => 'range',
      ),
    ),
    'single' => 
    array (
      'label' => '',
      'inputType' => 'number',
      'width' => 6,
      'relationMode' => '',
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
    'single_plus' => 
    array (
      'label' => '',
      'inputType' => 'number',
      'width' => 6,
      'relationMode' => '',
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
    'tw_db' => 
    array (
      'label' => '',
      'inputType' => 'number',
      'width' => 6,
      'relationMode' => '',
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
    'student' => 
    array (
      'label' => '',
      'inputType' => 'number',
      'width' => 6,
      'relationMode' => '',
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
    'fam_tr' => 
    array (
      'label' => '',
      'inputType' => 'number',
      'width' => 6,
      'relationMode' => '',
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
    'generatorVersion' => '2.8.0-dev1',
    'savedAt' => '2026-08-07T16:52:53+00:00',
    'schemaFingerprint' => 'dec72b42e3ab9a64d9fb72d57b87476549961337ebfd4ece9ed03c92acba355e',
    'configHash' => '54665797a3520e131e556d9fc942a5625ddb08ce8304069de010abeae07f70b2',
  ),
);
