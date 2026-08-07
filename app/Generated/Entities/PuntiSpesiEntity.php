<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class PuntiSpesiEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'data',
  1 => 'data_record',
);

    protected $casts = array (
  'punti_spesi_id' => 'integer',
  'hotel_id' => 'integer',
  'cliente_id' => 'integer',
  'conto_id' => 'integer',
  'punti' => 'integer',
  'utente_id' => 'integer',
);
}
