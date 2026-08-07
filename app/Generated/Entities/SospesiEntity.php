<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class SospesiEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'sospeso_data',
  1 => 'sospeso_data_record',
);

    protected $casts = array (
  'sospeso_id' => 'integer',
  'hotel_id' => 'integer',
  'pagamento_id' => 'integer',
  'cassa_id' => 'integer',
  'sospeso_conto_id' => 'integer',
  'sospeso_pratica_id' => 'integer',
  'sospeso_preno_id' => 'integer',
  'sospeso_fatt_numero' => 'integer',
  'sopeso_importo' => 'float',
  'sospeso_imp_conto' => 'float',
  'sopeso_societa' => 'integer',
  'sospeso_stato' => 'integer',
  'sospesi_utente_id' => 'integer',
);
}
