<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ManutenzioniEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'manut_data_segnalazione',
  1 => 'manut_data_record',
);

    protected $casts = array (
  'manutenzione_id' => 'integer',
  'hotel_id' => 'integer',
);
}
