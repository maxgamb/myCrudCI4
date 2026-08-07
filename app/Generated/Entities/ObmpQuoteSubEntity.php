<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ObmpQuoteSubEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'quote_sub_data',
);

    protected $casts = array (
  'obmp_quote_sub_id' => 'integer',
  'obmp_quote_id' => 'integer',
  'hotel_id' => 'integer',
);
}
