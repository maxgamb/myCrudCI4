<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class EfPriceTableEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'from',
  1 => 'to',
);

    protected $casts = array (
  'price_ef_is' => 'integer',
  'hotel_id' => 'integer',
  'single' => 'integer',
  'single_plus' => 'integer',
  'tw_db' => 'integer',
  'student' => 'integer',
  'fam_tr' => 'integer',
);
}
