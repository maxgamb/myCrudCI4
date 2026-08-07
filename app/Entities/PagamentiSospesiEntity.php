<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class PagamentiSospesiEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'data_pagamento',
  1 => 'data_rec_paga_sosp',
);

    protected $casts = array (
  'pagamento_id' => 'integer',
  'hotel_id' => 'integer',
  'sospeso_id' => 'integer',
  'paga_sosp_importo' => 'float',
  'pagamenti_sospesi_utente_id' => 'integer',
);
}
