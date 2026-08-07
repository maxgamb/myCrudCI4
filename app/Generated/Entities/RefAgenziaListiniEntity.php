<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class RefAgenziaListiniEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'ref_agenzia_datarecord',
);

    protected $casts = array (
  'ref_agenzia_listini_id' => 'integer',
  'agenzia_listini_id' => 'integer',
  'agenzia_id' => 'integer',
  'hotel_id' => 'integer',
  'agenzia_limite_vendita' => 'integer',
  'agenzia_ab_limite_vendita' => 'integer',
  'agenzia_max_vendita' => 'integer',
  'agenzia_ab_max_vendita' => 'integer',
);
}
