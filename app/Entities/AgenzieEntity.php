<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class AgenzieEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'agenzia_data_record',
);

    protected $casts = array (
  'agenzia_id' => 'integer',
  'hotel_id' => 'integer',
  'agenzie_utente_id' => 'integer',
);
}
