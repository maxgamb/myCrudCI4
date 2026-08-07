<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class AdebitiEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'adebiti_data_record',
);

    protected $casts = array (
  'adebito_id' => 'integer',
  'conto_id' => 'integer',
  'hotel_id' => 'integer',
  'prodotto_id' => 'integer',
  'prezzo' => 'float',
  'quantita' => 'integer',
  'adebiti_utente_id' => 'integer',
  'preno_id' => 'integer',
);
}
