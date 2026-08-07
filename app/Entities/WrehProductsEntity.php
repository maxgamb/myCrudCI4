<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class WrehProductsEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'product_id' => 'integer',
  'costi_area_id' => 'integer',
  'price' => 'float',
  'stock_quantity' => 'integer',
  'supplier_id' => 'integer',
);
}
