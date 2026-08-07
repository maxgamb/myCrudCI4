<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class AgenziaPrezziEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'agenzia_listini_dal',
  1 => 'agenzia_listini_al',
  2 => 'agenzia_prezzi_datarecord',
);

    protected $casts = array (
  'agenzia_prezzi_id' => 'integer',
  'hotel_id' => 'integer',
  'agenzia_listini_id' => 'integer',
  'agenzia_prezzi_1pax' => 'float',
  'agenzia_prezzi_2pax' => 'float',
  'agenzia_prezzi_3pax' => 'float',
  'agenzia_prezzi_4pax' => 'float',
  'agenzia_prezzi_free_pax' => 'integer',
  'agenzia_prezzi_free' => 'float',
  'agenzia_prezzi_portage' => 'float',
  'agenzia_prezzi_wdrink' => 'float',
  'agenzia_prezzi_american_bb' => 'float',
  'agenzia_prezzi_pranzo' => 'float',
  'agenzia_prezzi_cena' => 'float',
);
}
