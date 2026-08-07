<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class PuliziaEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'pulizia_data',
  1 => 'pulizia_data_record',
);

    protected $casts = array (
  'pulizia_id' => 'integer',
  'hotel_id' => 'integer',
  'conto_id' => 'integer',
  'camera_id' => 'integer',
  'cambio_biancheria' => 'integer',
  'pulizia_stato' => 'integer',
  'utente_id' => 'integer',
);
}
