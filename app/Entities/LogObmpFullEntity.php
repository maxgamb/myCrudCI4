<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class LogObmpFullEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'preno_dal',
  1 => 'preno_al',
  2 => 'today',
  3 => 'log_obmp_daterecord',
);

    protected $casts = array (
  'log_obmp_id_full' => 'integer',
  'Q1' => 'integer',
  'T1' => 'integer',
  'hotel_id' => 'integer',
);
}
