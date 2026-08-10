<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class FilmCategoryEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'last_update',
);

    protected $casts = array (
  'film_id' => 'integer',
  'category_id' => 'integer',
);
}
