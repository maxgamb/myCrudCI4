<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class RegistroPsEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'registro_ps_id' => 'integer',
  'registro_ps_hotel_id' => 'integer',
  'registro_ps_valore' => 'integer',
  'registro_ps_utente_id' => 'integer',
);
}
