<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CaxMotivoEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'data',
);

    protected $casts = array (
  'cax_motivo_id' => 'integer',
);
}
