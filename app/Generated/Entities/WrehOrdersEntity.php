<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class WrehOrdersEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'order_date',
);

    protected $casts = array (
  'order_id' => 'integer',
  'hotel_id' => 'integer',
  'utente_id' => 'integer',
);
}
