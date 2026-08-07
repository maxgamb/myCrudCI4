<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class FoglioGiornoEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'in_conto',
  1 => 'out_preno',
  2 => 'foglio_data_record',
);

    protected $casts = array (
  'foglio_id' => 'integer',
  'hotel_id' => 'integer',
  'conto_id' => 'integer',
  'camera_id' => 'integer',
  'preno_id' => 'integer',
  'tipologia_id' => 'integer',
  'numero_camera' => 'integer',
  'foglio_prezzo_camera' => 'float',
  'stato_camera' => 'integer',
  'preno_agenzia' => 'integer',
  'foglio_utente_id' => 'integer',
);
}
