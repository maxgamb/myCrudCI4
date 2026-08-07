<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ObmpClientiEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'obm_cliente_data_insert',
  1 => 'obm_cliente_data_record',
);

    protected $casts = array (
  'obm_cliente_id' => 'integer',
);
}
