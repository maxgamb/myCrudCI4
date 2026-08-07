<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ObmpRefSiteEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'ref_site_date_record',
);

    protected $casts = array (
  'ref_site_id' => 'integer',
  'hotel_id' => 'integer',
  'obmp_affiliati_id' => 'integer',
);
}
