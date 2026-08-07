<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ObmpCmRoomsEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'obmp_cm_rooms_data_record',
);

    protected $casts = array (
  'obmp_cm_rooms_id' => 'integer',
  'obmp_cm_id' => 'integer',
  'hotel_id' => 'integer',
  'obmp_cm_rooms_room_id' => 'integer',
  'obmp_cm_rooms_attiva' => 'integer',
  'obmp_cm_rooms_tipologia_id' => 'integer',
  'obmp_cm_rooms_room_var_prezzo' => 'float',
  'obmp_cm_rooms_room_min_prezzo' => 'float',
  'obmp_cm_rooms_max_pax' => 'integer',
  'obmp_cm_rooms_max_room' => 'integer',
  'obmp_cm_rooms_nesting' => 'integer',
  'citytax' => 'float',
);
}
