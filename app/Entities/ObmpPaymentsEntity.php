<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ObmpPaymentsEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'obmp_payment_id' => 'integer',
  'obmp_payment_value' => 'float',
);
}
