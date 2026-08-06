<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ClientusEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'clienti_data_record',
);

    protected $casts = array (
  'clienti_id' => 'integer',
  'preno_id' => 'integer',
  'hotel_id' => 'integer',
  'camera_id' => 'integer',
  'camera_numero' => 'integer',
  'privacy' => 'integer',
  'marketing' => 'integer',
  'clienti_utente_id' => 'integer',
);
}
