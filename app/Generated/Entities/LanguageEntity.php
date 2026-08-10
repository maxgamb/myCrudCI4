<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class LanguageEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'last_update',
);

    protected $casts = array (
  'language_id' => 'integer',
);
}
