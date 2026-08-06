<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class AgendaEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'preno_in_data',
  1 => 'preno_dal',
  2 => 'preno_al',
  3 => 'data_opzione',
  4 => 'cancella_data_record',
  5 => 'preno_data_record',
);

    protected $casts = array (
  'preno_id' => 'integer',
  'hotel_id' => 'integer',
  'preno_importo' => 'float',
  'preno_impoto_mod' => 'float',
  'preno_n_notti' => 'integer',
  't1' => 'integer',
  'q1' => 'integer',
  'p1' => 'float',
  't2' => 'integer',
  'q2' => 'integer',
  'p2' => 'float',
  't3' => 'integer',
  'q3' => 'integer',
  'p3' => 'float',
  't4' => 'integer',
  'q4' => 'integer',
  'p4' => 'float',
  't5' => 'integer',
  'q5' => 'integer',
  'p5' => 'float',
  't6' => 'integer',
  'q6' => 'integer',
  'p6' => 'float',
  'preno_agenzia' => 'integer',
  'allotment_id' => 'integer',
  'preno_pag_modalita' => 'integer',
  'preno_caparra' => 'float',
  'preno_stato' => 'integer',
  'cancella_user' => 'integer',
  'agenda_utente_id' => 'integer',
);
}
