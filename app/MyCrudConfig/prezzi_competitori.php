<?php

declare(strict_types=1);

/**
 * Configurazione persistente myCrudGpt per la tabella prezzi_competitori.
 *
 * Questo file contiene solo le scelte dello sviluppatore.
 * Tipi DB, indici e relazioni vengono riletti dallo schema ad ogni generazione.
 */
return array (
  'table' => 'prezzi_competitori',
  'architecture' => 'full',
  'order' => 
  array (
    0 => 'prezzi_competitori_id',
    1 => 'hotel_id',
    2 => 'data_prezzo',
    3 => 'percentile_10',
    4 => 'percentile_25',
    5 => 'percentile_50',
    6 => 'percentile_75',
    7 => 'percentile_90',
    8 => 'indice_disponibilita',
    9 => 'data_acuisizione',
  ),
  'fields' => 
  array (
    'prezzi_competitori_id' => 
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
    'data_prezzo' => 
    array (
      'label' => '',
      'inputType' => 'date',
      'width' => 6,
      'relationMode' => '',
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
        'filterMode' => 'range',
      ),
    ),
    'percentile_10' => 
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
    'percentile_25' => 
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
    'percentile_50' => 
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
    'percentile_75' => 
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
    'percentile_90' => 
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
    'indice_disponibilita' => 
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
    'data_acuisizione' => 
    array (
      'label' => '',
      'inputType' => 'date',
      'width' => 6,
      'relationMode' => '',
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
    'savedAt' => '2026-08-07T16:52:54+00:00',
    'schemaFingerprint' => '91db21068f4fd2d520877273a41bf17c23a20e5ce5cac1b0eea8b6e190e6b4fd',
    'configHash' => '1e91fcadfe34c03dd106a23255e21e39c61dba0a2c0c7233187a2e991ff54410',
  ),
);
