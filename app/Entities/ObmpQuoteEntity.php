<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ObmpQuoteEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'quote_dal',
  1 => 'quote_al',
  2 => 'quote_del',
  3 => 'quote_data_time',
);

    protected $casts = array (
  'quote_id' => 'integer',
  'hotel_id' => 'integer',
  'trariffa_id' => 'integer',
  'cax_policy_id' => 'integer',
  'quote_tel_rich' => 'integer',
  'quote_cc_rich' => 'integer',
  'utente_id' => 'integer',
  'quote_stato' => 'integer',
);
}
