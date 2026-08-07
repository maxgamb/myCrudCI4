<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ParsedEmailsEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'created_at',
);

    protected $casts = array (
  'id' => 'integer',
  'hotel_id' => 'integer',
);
}
