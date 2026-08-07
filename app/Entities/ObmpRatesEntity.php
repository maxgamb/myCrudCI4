<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ObmpRatesEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'obmp_rate_id' => 'integer',
  'obmp_cm_rooms_id' => 'integer',
  'obmp_restriction_id' => 'integer',
  'hotel_id' => 'integer',
  'rate_sum' => 'float',
  'rate_mol' => 'float',
  'rate_stato' => 'integer',
);
}
