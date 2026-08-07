<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ListinoObmpEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'listino_obmp_datarecord',
);

    protected $casts = array (
  'listino_id' => 'integer',
  'hotel_id' => 'integer',
  'listino_nome_id' => 'integer',
  'tipologia_id' => 'integer',
  'listino_prezzo' => 'float',
  'ref_site' => 'integer',
  'ref_agency' => 'integer',
  'ref_event' => 'integer',
  'ref_session' => 'integer',
  'ref_cookie' => 'integer',
);
}
