<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class StaffEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'staff_datarecod',
);

    protected $casts = array (
  'staff_id' => 'integer',
  'staff_stato' => 'integer',
  'utente_id' => 'integer',
);
}
