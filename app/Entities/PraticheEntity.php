<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class PraticheEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'pratica_data_record',
);

    protected $casts = array (
  'pratica_id' => 'integer',
  'hotel_id' => 'integer',
  'pratica_agenzia_id' => 'integer',
  'pratica_stato' => 'integer',
  'pratiche_utente_id' => 'integer',
);
}
