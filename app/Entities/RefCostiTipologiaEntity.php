<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class RefCostiTipologiaEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'ref_costi_data_record',
);

    protected $casts = array (
  'ref_costi_tipologia_id' => 'integer',
  'costi_var_id' => 'integer',
  'tipologia_id' => 'integer',
  'hotel_id' => 'integer',
  'stay' => 'integer',
  'days' => 'integer',
  'check_out' => 'integer',
  'utente_id' => 'integer',
);
}
