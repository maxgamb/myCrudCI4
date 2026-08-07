<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CompetitoriEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'competitore_data_record',
);

    protected $casts = array (
  'competitore_id' => 'integer',
  'hotel_id' => 'integer',
  'livello_dicompetizione' => 'integer',
  'competitore_venere_id' => 'integer',
  'qualita_trivago' => 'integer',
);
}
