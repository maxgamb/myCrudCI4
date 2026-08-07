<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ObmpCancellationsEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'obmp_cancellation_id' => 'integer',
  'obmp_cancellation_day' => 'integer',
);
}
