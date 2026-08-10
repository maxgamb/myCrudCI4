<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class FilmActorEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'last_update',
);

    protected $casts = array (
  'actor_id' => 'integer',
  'film_id' => 'integer',
);
}
