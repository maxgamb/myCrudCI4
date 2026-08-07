<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ColoriEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'colore_data_record',
);

    protected $casts = array (
  'col_preno_id' => 'integer',
);
}
