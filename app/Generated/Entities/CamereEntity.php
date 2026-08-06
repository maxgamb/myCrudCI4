<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CamereEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'camere_data_record',
);

    protected $casts = array (
  'camera_id' => 'integer',
  'hotel_id' => 'integer',
  'numero_camera' => 'integer',
  'tipologia_id' => 'integer',
  'camere_max_pax' => 'integer',
  'camere_metri_quadri' => 'float',
  'camere_piano' => 'float',
  'review_tot' => 'float',
  'camere_utente_id' => 'integer',
);
}
