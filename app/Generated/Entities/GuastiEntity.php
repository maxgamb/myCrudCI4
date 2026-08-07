<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class GuastiEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'guasto_data',
  1 => 'guasto_data_record',
);

    protected $casts = array (
  'guasto_id' => 'integer',
  'hotel_id' => 'integer',
  'camera_id' => 'integer',
  'guasto_priorita' => 'integer',
  'guasto_stato' => 'integer',
  'guasto_utente_id' => 'integer',
);
}
