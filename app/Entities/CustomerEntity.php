<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CustomerEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'create_date',
  1 => 'last_update',
);

    protected $casts = array (
  'customer_id' => 'integer',
  'store_id' => 'integer',
  'address_id' => 'integer',
  'active' => 'boolean',
);
}
