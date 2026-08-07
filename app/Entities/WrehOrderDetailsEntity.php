<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class WrehOrderDetailsEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'order_detail_id' => 'integer',
  'order_id' => 'integer',
  'product_id' => 'integer',
  'quantity' => 'integer',
  'price' => 'float',
  'utente_id' => 'integer',
);
}
