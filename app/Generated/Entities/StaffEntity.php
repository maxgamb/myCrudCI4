<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class StaffEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'last_update',
);

    protected $casts = array (
  'staff_id' => 'integer',
  'address_id' => 'integer',
  'store_id' => 'integer',
  'active' => 'boolean',
);
}
