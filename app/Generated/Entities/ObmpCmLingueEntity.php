<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ObmpCmLingueEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'obmp_cm_lingue_data_record',
);

    protected $casts = array (
  'obmp_cm_lingue_id' => 'integer',
  'obmp_cm_rooms_id' => 'integer',
  'hotel_id' => 'integer',
);
}
