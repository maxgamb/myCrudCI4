<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ShiftsEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'shift_date',
  1 => 'data_record',
);

    protected $casts = array (
  'id' => 'integer',
  'staff_id' => 'integer',
  'hotel_id' => 'integer',
  'position' => 'integer',
);
}
