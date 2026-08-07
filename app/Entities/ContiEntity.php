<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ContiEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'in_conto',
  1 => 'in_conto_time',
  2 => 'out_preno',
  3 => 'out_conto',
  4 => 'data_record',
);

    protected $casts = array (
  'conto_id' => 'integer',
  'hotel_id' => 'integer',
  'foglio_id' => 'integer',
  'clienti_id' => 'integer',
  'preno_id' => 'integer',
  'camera_id' => 'integer',
  'numero_camera' => 'integer',
  'tipologia_id' => 'integer',
  'prezzo' => 'float',
  'preno_agenzia' => 'integer',
  'conti_stato_camere' => 'integer',
  'acconto' => 'float',
  'conti_utente_id' => 'integer',
);
}
