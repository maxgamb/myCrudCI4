<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ListinoPeriodiObmpEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'listino_dal',
  1 => 'listino_al',
  2 => 'listino_periodi',
);

    protected $casts = array (
  'listino_periodi_id' => 'integer',
  'listino_nome_id' => 'integer',
  'listino_periodi_flex' => 'integer',
  'hotel_id' => 'integer',
);
}
