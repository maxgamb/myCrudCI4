<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CostiAreaEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'costi_area_data_record',
);

    protected $casts = array (
  'costi_area_id' => 'integer',
  'utente_id' => 'integer',
);
}
