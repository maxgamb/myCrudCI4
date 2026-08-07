<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class TipDocEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'tip_doc_id' => 'integer',
);
}
