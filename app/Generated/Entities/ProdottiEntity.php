<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ProdottiEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'prodotti_data_record',
);

    protected $casts = array (
  'prodotto_id' => 'integer',
  'prodotti_lista_id' => 'integer',
  'hotel_id' => 'integer',
  'prezzo_prodotto' => 'float',
  'cent_costo_prodotto' => 'float',
  'prodotti_utente_id' => 'integer',
);
}
