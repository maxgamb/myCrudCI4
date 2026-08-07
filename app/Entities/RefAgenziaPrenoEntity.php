<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class RefAgenziaPrenoEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'ref_a_p_datarecord',
);

    protected $casts = array (
  'ref_agenzia_preno' => 'integer',
  'agenzia_id' => 'integer',
  'preno_id' => 'integer',
);
}
