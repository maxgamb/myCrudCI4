<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class LogRichiesteEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'log_ric_dal',
  1 => 'log_ric_al',
  2 => 'log_ric_data',
);

    protected $casts = array (
  'log_ric_id' => 'integer',
  'log_ric_hotel_id' => 'integer',
  'log_ric_notti' => 'integer',
  'log_ric_wind' => 'integer',
  'log_ric_utente_id' => 'integer',
);
}
