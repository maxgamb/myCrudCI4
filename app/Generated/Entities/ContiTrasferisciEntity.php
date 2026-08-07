<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ContiTrasferisciEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'conti_tra_data',
);

    protected $casts = array (
  'conti_trasferisci_id' => 'integer',
  'conto_id_ex' => 'integer',
  'conto_id_new' => 'integer',
  'hotel_id' => 'integer',
  'adebito_id' => 'integer',
);
}
