<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CityEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'last_update',
);

    protected $casts = array (
  'city_id' => 'integer',
  'country_id' => 'integer',
);
}
