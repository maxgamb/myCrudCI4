<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CountryEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'last_update',
);

    protected $casts = array (
  'country_id' => 'integer',
);
}
