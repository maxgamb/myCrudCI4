<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class LettereEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'data_stamp',
);

    protected $casts = array (
  'lettere_id' => 'integer',
  'hotel_id' => 'integer',
);
}
