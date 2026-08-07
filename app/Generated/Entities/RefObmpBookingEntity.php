<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class RefObmpBookingEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'ref_obm_data',
);

    protected $casts = array (
  'preno_id' => 'integer',
  'obm_cliente_id' => 'integer',
  'hotel_id' => 'integer',
  'ref_site' => 'integer',
  'ref_agency' => 'integer',
  'ref_event' => 'integer',
  'quote_id' => 'integer',
);
}
