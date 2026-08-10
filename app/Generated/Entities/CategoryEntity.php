<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CategoryEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'last_update',
);

    protected $casts = array (
  'category_id' => 'integer',
);
}
