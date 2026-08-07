<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ProdottiListaEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'prod_lista_data',
);

    protected $casts = array (
  'prodotti_lista_id' => 'integer',
  'prod_lista_costo_unitario' => 'float',
  'prod_lista_user_id' => 'integer',
);
}
