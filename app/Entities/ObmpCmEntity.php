<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ObmpCmEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'obmp_cm_data_record',
);

    protected $casts = array (
  'obmp_cm_id' => 'integer',
  'hotel_id' => 'integer',
  'agenzia_id' => 'integer',
  'obmp_cm_attiva' => 'integer',
  'obmp_cm_tipologia_id1' => 'integer',
  'obmp_cm_room_id1' => 'integer',
  'obmp_cm_tipologia_id2' => 'integer',
  'obmp_cm_room_id2' => 'integer',
  'obmp_cm_tipologia_id3' => 'integer',
  'obmp_cm_room_id3' => 'integer',
  'obmp_cm_tipologia_id4' => 'integer',
  'obmp_cm_room_id4' => 'integer',
  'obmp_cm_tipologia_id5' => 'integer',
  'obmp_cm_room_id5' => 'integer',
  'obmp_cm_tipologia_id6' => 'integer',
  'obmp_cm_room_id6' => 'integer',
  'obmp_cm_tipologia_id7' => 'integer',
  'obmp_cm_room_id7' => 'integer',
  'obmp_cm_tipologia_id8' => 'integer',
  'obmp_cm_room_id8' => 'integer',
  'obmp_cm_tipologia_id9' => 'integer',
  'obmp_cm_room_id9' => 'integer',
  'obmp_cm_tipologia_id10' => 'integer',
  'obmp_cm_room_id10' => 'integer',
  'obmp_cm_moltiplicatore' => 'float',
  'obmp_cm_max_camere' => 'integer',
  'obmp_cm_min_camare' => 'integer',
  'obmp_cm_utente_id' => 'integer',
);
}
