<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class UtentiEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'utenti_data_record',
);

    protected $casts = array (
  'Utente_id' => 'integer',
  'staff_id' => 'integer',
  'hotel_id' => 'integer',
  'utenti_livello' => 'integer',
  'utenti_Utente_id' => 'integer',
);
}
