<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ImagesEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'data_record',
);

    protected $casts = array (
  'images_id' => 'integer',
  'hotel_id' => 'integer',
  'camera_id' => 'integer',
  'obmp_cm_rooms_id' => 'integer',
  'tipologia_id' => 'integer',
  'utente_id' => 'integer',
);
}
