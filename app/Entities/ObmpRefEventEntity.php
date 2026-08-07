<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ObmpRefEventEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'event_dal',
  1 => 'event_al',
  2 => 'ref_event_data_record',
);

    protected $casts = array (
  'ref_event_id' => 'integer',
  'ref_site_id' => 'integer',
  'hotel_id' => 'integer',
  'listino_nome_id' => 'integer',
  'agenzia_id' => 'integer',
);
}
