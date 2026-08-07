<?php

declare(strict_types=1);

/**
 * Configurazione persistente myCrudGpt per la tabella agenzia_prezzi.
 *
 * Questo file contiene solo le scelte dello sviluppatore.
 * Tipi DB, indici e relazioni vengono riletti dallo schema ad ogni generazione.
 */
return array (
  'table' => 'agenzia_prezzi',
  'architecture' => 'full',
  'order' => 
  array (
    0 => 'agenzia_prezzi_id',
    1 => 'hotel_id',
    2 => 'agenzia_listini_id',
    3 => 'agenzia_listini_dal',
    4 => 'agenzia_listini_al',
    5 => 'agenzia_prezzi_1pax',
    6 => 'agenzia_prezzi_2pax',
    7 => 'agenzia_prezzi_3pax',
    8 => 'agenzia_prezzi_4pax',
    9 => 'agenzia_prezzi_free_pax',
    10 => 'agenzia_prezzi_free',
    11 => 'agenzia_prezzi_portage',
    12 => 'agenzia_prezzi_wdrink',
    13 => 'agenzia_prezzi_american_bb',
    14 => 'agenzia_prezzi_pranzo',
    15 => 'agenzia_prezzi_cena',
    16 => 'agenzia_prezzi_nome',
    17 => 'agenzia_prezzi_note',
    18 => 'agenzia_prezzi_datarecord',
  ),
  'fields' => 
  array (
    'agenzia_prezzi_id' => 
    array (
      'label' => '',
      'inputType' => 'select',
      'width' => 6,
      'relationMode' => 'select',
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
    'agenzia_listini_id' => 
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
    'agenzia_listini_dal' => 
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
    'agenzia_listini_al' => 
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
    'agenzia_prezzi_1pax' => 
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
    'agenzia_prezzi_2pax' => 
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
    'agenzia_prezzi_3pax' => 
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
    'agenzia_prezzi_4pax' => 
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
    'agenzia_prezzi_free_pax' => 
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
        'visibleIndex' => false,
        'visibleForm' => true,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'exact',
      ),
    ),
    'agenzia_prezzi_free' => 
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
        'visibleIndex' => false,
        'visibleForm' => true,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'exact',
      ),
    ),
    'agenzia_prezzi_portage' => 
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
        'visibleIndex' => false,
        'visibleForm' => true,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'exact',
      ),
    ),
    'agenzia_prezzi_wdrink' => 
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
        'visibleIndex' => false,
        'visibleForm' => true,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'exact',
      ),
    ),
    'agenzia_prezzi_american_bb' => 
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
        'visibleIndex' => false,
        'visibleForm' => true,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'exact',
      ),
    ),
    'agenzia_prezzi_pranzo' => 
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
        'visibleIndex' => false,
        'visibleForm' => true,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'exact',
      ),
    ),
    'agenzia_prezzi_cena' => 
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
        'visibleIndex' => false,
        'visibleForm' => true,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'exact',
      ),
    ),
    'agenzia_prezzi_nome' => 
    array (
      'label' => '',
      'inputType' => 'text',
      'width' => 6,
      'relationMode' => '',
      'attributes' => 
      array (
        'boolean' => 
        array (
        ),
        'values' => 
        array (
          'maxlength' => '250',
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
    'agenzia_prezzi_note' => 
    array (
      'label' => '',
      'inputType' => 'text',
      'width' => 6,
      'relationMode' => '',
      'attributes' => 
      array (
        'boolean' => 
        array (
        ),
        'values' => 
        array (
          'maxlength' => '250',
        ),
      ),
      'ui' => 
      array (
        'searchable' => false,
        'sortable' => false,
        'visibleIndex' => false,
        'visibleForm' => true,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'prefix',
      ),
    ),
    'agenzia_prezzi_datarecord' => 
    array (
      'label' => '',
      'inputType' => 'datetime-local',
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
        'visibleIndex' => false,
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
    'savedAt' => '2026-08-07T16:52:53+00:00',
    'schemaFingerprint' => '194ecc5ac6d31bbb1a9ba77ebb0adab6e728d92a8a8e5c4c6e90c33319cd0a33',
    'configHash' => '5e27c5948bc84232b134583199bfa65d5ec52d76c165997bb2971371bcc5a5c8',
  ),
);
