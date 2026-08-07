<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class TaxPagamentoEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'data_pagamento',
  1 => 'tax_pagamento_data_record',
);

    protected $casts = array (
  'tax_pagamento_id' => 'integer',
  'hotel_id' => 'integer',
  'conto_id' => 'integer',
  'pratica_id' => 'integer',
  'importo' => 'float',
  'tassa_stato' => 'integer',
  'tax_pagamento_utente_id' => 'integer',
);
}
