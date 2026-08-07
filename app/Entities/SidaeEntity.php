<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class SidaeEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'data',
  1 => 'data_record',
);

    protected $casts = array (
  'sidae_id' => 'integer',
  'hotel_id' => 'integer',
  'conto_id' => 'integer',
  'foglio_id' => 'integer',
  'pag_room' => 'float',
  'aliquota' => 'float',
  'quan_room' => 'integer',
  'pag_extra' => 'float',
  'extra_aliquota' => 'integer',
  'pag_citytax' => 'float',
  'se_idTrx' => 'integer',
  'ae_idTrx' => 'integer',
  'totaleScontrino' => 'float',
  'totaleIva' => 'float',
  'totaleSconto' => 'float',
  'importoDetraibile' => 'float',
  'utente_id' => 'integer',
);
}
