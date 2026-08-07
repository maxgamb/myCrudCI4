<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class BlackListEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'black_list_data',
);

    protected $casts = array (
  'black_list_id' => 'integer',
  'hotel_id' => 'integer',
  'clienti_id' => 'integer',
  'black_list_stato' => 'integer',
);
}
