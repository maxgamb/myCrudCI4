<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class TipologiaCameraEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'tipologia_camera_data_record',
);

    protected $casts = array (
  'tipologia_id' => 'integer',
  'tipologia_camera_utente_id' => 'integer',
  'perc_prezzo' => 'integer',
);
}
