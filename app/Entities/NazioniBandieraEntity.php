<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class NazioniBandieraEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'Nazioni_Codice' => 'integer',
);
}
