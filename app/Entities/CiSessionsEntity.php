<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CiSessionsEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'timestamp' => 'integer',
);
}
