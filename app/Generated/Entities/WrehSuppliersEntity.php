<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class WrehSuppliersEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'supplier_id' => 'integer',
  'utente_id' => 'integer',
);
}
