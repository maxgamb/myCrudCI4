<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class StoreEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'last_update',
);

    protected $casts = array (
  'store_id' => 'integer',
  'manager_staff_id' => 'integer',
  'address_id' => 'integer',
);
}
