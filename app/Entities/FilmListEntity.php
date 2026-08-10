<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class FilmListEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'FID' => 'integer',
  'price' => 'float',
  'length' => 'integer',
);
}
