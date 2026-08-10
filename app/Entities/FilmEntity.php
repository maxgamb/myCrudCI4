<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class FilmEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'last_update',
);

    protected $casts = array (
  'film_id' => 'integer',
  'language_id' => 'integer',
  'original_language_id' => 'integer',
  'rental_duration' => 'integer',
  'rental_rate' => 'float',
  'length' => 'integer',
  'replacement_cost' => 'float',
);
}
