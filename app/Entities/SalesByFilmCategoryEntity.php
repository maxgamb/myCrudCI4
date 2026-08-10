<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class SalesByFilmCategoryEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'total_sales' => 'float',
);
}
