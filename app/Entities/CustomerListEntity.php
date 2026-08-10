<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CustomerListEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'ID' => 'integer',
  'SID' => 'integer',
);
}
