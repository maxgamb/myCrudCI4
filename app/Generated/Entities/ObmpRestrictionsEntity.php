<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ObmpRestrictionsEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'obmp_restriction_id' => 'integer',
  'restr_min_stay' => 'integer',
  'restr_max_stay' => 'integer',
  'restr_min_bw' => 'integer',
  'restr_max_bw' => 'integer',
);
}
