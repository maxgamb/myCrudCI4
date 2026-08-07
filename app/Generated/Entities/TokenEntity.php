<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class TokenEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'token_data',
  1 => 'token_data_record',
);

    protected $casts = array (
  'token_id' => 'integer',
  'hotel_id' => 'integer',
);
}
