<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class BancaHotelEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'banca_hotel_id' => 'integer',
  'hotel_id' => 'integer',
  'banca_utente_id' => 'integer',
);
}
