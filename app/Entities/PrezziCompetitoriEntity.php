<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class PrezziCompetitoriEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'data_prezzo',
  1 => 'data_acuisizione',
);

    protected $casts = array (
  'prezzi_competitori_id' => 'integer',
  'hotel_id' => 'integer',
  'percentile_10' => 'float',
  'percentile_25' => 'float',
  'percentile_50' => 'float',
  'percentile_75' => 'float',
  'percentile_90' => 'float',
  'indice_disponibilita' => 'float',
);
}
