<?php

declare(strict_types=1);

/**
 * Configurazione persistente myCrudGpt per la tabella tipologia_camera.
 *
 * Questo file contiene solo le scelte dello sviluppatore.
 * Tipi DB, indici e relazioni vengono riletti dallo schema ad ogni generazione.
 */
return array (
  'table' => 'tipologia_camera',
  'architecture' => 'full',
  'order' => 
  array (
    0 => 'tipologia_id',
    1 => 'nome_tipologia',
    2 => 'nome_tipologia_en',
    3 => 'nome_tipologia_fr',
    4 => 'nome_tipologia_de',
    5 => 'nome_tipologia_sp',
    6 => 'nome_tipologia_jp',
    7 => 'tipologia_sigla',
    8 => 'numero_pax',
    9 => 'tipologia_camera_data_record',
    10 => 'tipologia_camera_utente_id',
    11 => 'perc_prezzo',
  ),
  'fields' => 
  array (
    'tipologia_id' => 
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
    'nome_tipologia' => 
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
      'attributes' => 
      array (
        'boolean' => 
        array (
        ),
        'values' => 
        array (
          'maxlength' => '100',
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
    'nome_tipologia_en' => 
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
      'attributes' => 
      array (
        'boolean' => 
        array (
        ),
        'values' => 
        array (
          'maxlength' => '200',
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
    'nome_tipologia_fr' => 
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
      'attributes' => 
      array (
        'boolean' => 
        array (
        ),
        'values' => 
        array (
          'maxlength' => '200',
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
    'nome_tipologia_de' => 
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
      'attributes' => 
      array (
        'boolean' => 
        array (
        ),
        'values' => 
        array (
          'maxlength' => '200',
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
    'nome_tipologia_sp' => 
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
      'attributes' => 
      array (
        'boolean' => 
        array (
        ),
        'values' => 
        array (
          'maxlength' => '200',
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
    'nome_tipologia_jp' => 
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
      'attributes' => 
      array (
        'boolean' => 
        array (
        ),
        'values' => 
        array (
          'maxlength' => '200',
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
    'tipologia_sigla' => 
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
      'attributes' => 
      array (
        'boolean' => 
        array (
          0 => 'required',
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
        'visibleForm' => true,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'prefix',
      ),
    ),
    'numero_pax' => 
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
      'attributes' => 
      array (
        'boolean' => 
        array (
        ),
        'values' => 
        array (
          'maxlength' => '100',
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
    'tipologia_camera_data_record' => 
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
        'visibleForm' => false,
        'visibleView' => false,
        'sensitive' => false,
        'exportable' => false,
        'apiVisible' => false,
        'filterMode' => 'range',
      ),
    ),
    'tipologia_camera_utente_id' => 
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
    'perc_prezzo' => 
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
      'camere__tipologia_id' => 
      array (
        'enabled' => true,
        'title' => 'Camere',
        'icon' => 'bi-diagram-3',
        'limit' => 20,
        'showCount' => true,
        'showViewButton' => true,
        'columns' => 
        array (
          0 => 'camera_id',
          1 => 'hotel_id',
          2 => 'numero_camera',
          3 => 'tipologia_camera',
          4 => 'camere_max_pax',
          5 => 'camere_metri_quadri',
        ),
      ),
      'foglio_giorno__tipologia_id' => 
      array (
        'enabled' => true,
        'title' => 'Foglio Giorno',
        'icon' => 'bi-diagram-3',
        'limit' => 20,
        'showCount' => true,
        'showViewButton' => true,
        'columns' => 
        array (
          0 => 'foglio_id',
          1 => 'hotel_id',
          2 => 'conto_id',
          3 => 'camera_id',
          4 => 'preno_id',
          5 => 'numero_camera',
        ),
      ),
      'obmp_cm_rooms__obmp_cm_rooms_tipologia_id' => 
      array (
        'enabled' => true,
        'title' => 'Obmp Cm Rooms',
        'icon' => 'bi-diagram-3',
        'limit' => 20,
        'showCount' => true,
        'showViewButton' => true,
        'columns' => 
        array (
          0 => 'obmp_cm_rooms_id',
          1 => 'obmp_cm_id',
          2 => 'hotel_id',
          3 => 'obmp_cm_rooms_room_id',
          4 => 'obmp_cm_rooms_attiva',
          5 => 'obmp_cm_rooms_room_note',
        ),
      ),
      'ref_costi_tipologia__tipologia_id' => 
      array (
        'enabled' => true,
        'title' => 'Ref Costi Tipologia',
        'icon' => 'bi-diagram-3',
        'limit' => 20,
        'showCount' => true,
        'showViewButton' => true,
        'columns' => 
        array (
          0 => 'ref_costi_tipologia_id',
          1 => 'costi_var_id',
          2 => 'hotel_id',
          3 => 'stay',
          4 => 'days',
          5 => 'check_out',
        ),
      ),
    ),
  ),
  'list' => 
  array (
    'filtersSummary' => 'Filtri di ricerca',
  ),
  '_meta' => 
  array (
    'generatorVersion' => '2.8.0-dev9',
    'savedAt' => '2026-08-08T15:46:31+00:00',
    'schemaFingerprint' => 'c2e3215c24b15bf74d1f5aab7e40607d5da66a62b7790360abfa8cf6bef26ac3',
    'configHash' => 'ea708d476d123d7d7c45bc5f5646c764cbc1dc0abc927f0c02b5ae90a37a7aaf',
  ),
);
