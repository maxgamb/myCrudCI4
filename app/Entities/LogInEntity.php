<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class LogInEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'log_time',
);

    protected $casts = array (
  'log_in_id' => 'integer',
);
}
