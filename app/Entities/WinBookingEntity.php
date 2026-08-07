<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class WinBookingEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'win_id' => 'integer',
  'hotel_id' => 'integer',
  'win_dal' => 'integer',
  'win_al' => 'integer',
  'mese' => 'integer',
  'win_hotel' => 'integer',
  'win_comp' => 'integer',
  'win_hotel_cum' => 'integer',
  'win_comp_cum' => 'integer',
);
}
