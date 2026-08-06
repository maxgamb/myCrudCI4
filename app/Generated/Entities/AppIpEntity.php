<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class AppIpEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'data',
);

    protected $casts = array (
  'app_ip_id' => 'integer',
  'Livello' => 'integer',
);
}
