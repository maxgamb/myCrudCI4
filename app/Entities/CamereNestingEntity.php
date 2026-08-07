<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CamereNestingEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'nesting_data_record',
);

    protected $casts = array (
  'nesting_id' => 'integer',
  'camara_id' => 'integer',
  'tipologia_id' => 'integer',
  'voto' => 'integer',
  'nesting_utente_id' => 'integer',
);
}
