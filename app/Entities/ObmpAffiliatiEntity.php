<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ObmpAffiliatiEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'obmp_aff_data_record',
);

    protected $casts = array (
  'obmp_affiliati_id' => 'integer',
  'obmp_aff_cookies' => 'integer',
  'obmp_aff_commisione' => 'float',
  'obmp_aff_mark_up' => 'float',
);
}
