<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class StaffListEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'ID' => 'integer',
  'SID' => 'integer',
);
}
