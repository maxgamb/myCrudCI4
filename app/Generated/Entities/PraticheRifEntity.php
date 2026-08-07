<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class PraticheRifEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'pratica_rif_out_conto',
  1 => 'pratica_rif_data_record',
);

    protected $casts = array (
  'pratica_rif_pratica_id' => 'integer',
  'hotel_id' => 'integer',
  'pratica_rif_conto_id' => 'integer',
  'pratica_rif_totale_modificato' => 'float',
  'pratica_rif_totale_importo' => 'float',
  'pratica_rif_pagamento_importo_pag' => 'float',
  'pratiche_rif_id' => 'integer',
);
}
