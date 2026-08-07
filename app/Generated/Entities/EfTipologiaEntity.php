<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class EfTipologiaEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'pax' => 'integer',
  4 => 'integer',
  3 => 'integer',
  2 => 'integer',
  1 => 'integer',
);
}
