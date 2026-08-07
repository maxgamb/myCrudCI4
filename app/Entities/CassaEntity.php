<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CassaEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'out_conto',
  1 => 'cassa_data_record',
);

    protected $casts = array (
  'cassa_id' => 'integer',
  'hotel_id' => 'integer',
  'preno_id' => 'integer',
  'conto_id' => 'integer',
  'totale_importo' => 'float',
  'totale_modificato' => 'float',
  'pagamento_importo_pag' => 'float',
  'fattura_numero' => 'integer',
  'cassa_utente_id' => 'integer',
);
}
