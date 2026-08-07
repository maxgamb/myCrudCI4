<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class PrezziEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'prezzo_dal',
  1 => 'prezzo_al',
  2 => 'prezzo_data_record',
);

    protected $casts = array (
  'prezzo_id' => 'integer',
  'hotel_id' => 'integer',
  'conto_id' => 'integer',
  'prezzo_valore' => 'float',
  'prezzi_utente_id' => 'integer',
);
}
