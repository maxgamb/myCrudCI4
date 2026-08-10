<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ActorInfoEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'actor_id' => 'integer',
);
}
