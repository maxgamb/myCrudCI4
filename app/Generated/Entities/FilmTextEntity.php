<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class FilmTextEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'film_id' => 'integer',
);
}
