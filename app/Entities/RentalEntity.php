<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class RentalEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'rental_date',
  1 => 'return_date',
  2 => 'last_update',
);

    protected $casts = array (
  'rental_id' => 'integer',
  'inventory_id' => 'integer',
  'customer_id' => 'integer',
  'staff_id' => 'integer',
);
}
