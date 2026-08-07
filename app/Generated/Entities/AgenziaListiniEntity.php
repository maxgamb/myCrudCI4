<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class AgenziaListiniEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'agenzia_listini_datarecord',
);

    protected $casts = array (
  'agenzia_listini_id' => 'integer',
  'hotel_id' => 'integer',
);
}
