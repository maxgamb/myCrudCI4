<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class AddressEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'last_update',
);

    protected $casts = array (
  'address_id' => 'integer',
  'city_id' => 'integer',
);
}
