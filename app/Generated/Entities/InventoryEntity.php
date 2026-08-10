<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class InventoryEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'last_update',
);

    protected $casts = array (
  'inventory_id' => 'integer',
  'film_id' => 'integer',
  'store_id' => 'integer',
);
}
