<?php

declare(strict_types=1);

/**
 * Configurazione persistente myCrudGpt per la tabella modifica_agenda.
 *
 * Questo file contiene solo le scelte dello sviluppatore.
 * Tipi DB, indici e relazioni vengono riletti dallo schema ad ogni generazione.
 */
return array (
  'table' => 'modifica_agenda',
  'architecture' => 'full',
  'order' => 
  array (
    0 => 'mod_agenda_id',
    1 => 'mod_preno_id',
    2 => 'mod_agenda_valori',
    3 => 'mod_preno_data_records',
    4 => 'modifica_agenda_adebiti_utente_id',
  ),
  'fields' => 
  array (
    'mod_agenda_id' => 
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
    'mod_preno_id' => 
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
    'mod_agenda_valori' => 
    array (
      'label' => '',
      'inputType' => 'text',
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
          'maxlength' => '4294967295',
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
    'mod_preno_data_records' => 
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
        'visibleIndex' => true,
        'visibleForm' => true,
        'visibleView' => true,
        'sensitive' => false,
        'exportable' => true,
        'apiVisible' => true,
        'filterMode' => 'range',
      ),
    ),
    'modifica_agenda_adebiti_utente_id' => 
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
    'schemaFingerprint' => '322de3c521093fd17ab8d80d860dae4783e199a34d834ae95819dded6aa3c01a',
    'configHash' => 'e7f38fe2d376344d0d15e4f8a79a711e33cbfe3721c1e051876281a13d21f671',
  ),
);
