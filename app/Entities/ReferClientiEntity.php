<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ReferClientiEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'ref_clinti_data_record',
);

    protected $casts = array (
  'conto_id' => 'integer',
  'clienti_id' => 'integer',
  'hotel_id' => 'integer',
  'ps_valore' => 'integer',
  'refer_clienti_utente_id' => 'integer',
  'refer_clienti_conto_id' => 'integer',
);
}
