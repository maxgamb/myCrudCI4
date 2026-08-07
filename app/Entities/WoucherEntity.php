<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class WoucherEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'woucher_in',
  1 => 'woucher_out',
  2 => 'woucher_data_record',
);

    protected $casts = array (
  'woucher_id' => 'integer',
  'woucher_agenzia_id' => 'integer',
  'woucher_preno_id' => 'integer',
  'woucher_hotel_id' => 'integer',
  'woucher_notti' => 'integer',
  'woucher_singole' => 'integer',
  'woucher_singole_staff' => 'integer',
  'woucher_doppia' => 'integer',
  'woucher_tripla' => 'integer',
  'woucher_quadrupla' => 'integer',
  'woucher_cildren_n' => 'integer',
  'woucher_doppia_studenti' => 'integer',
  'woucher_tripla_studenti' => 'integer',
  'woucher_quadrupla_studenti' => 'integer',
  'woucher_quintupla_studenti' => 'integer',
  'woucher_tot_pax' => 'integer',
  'woucher_tot_adulti' => 'integer',
  'woucher_tot_studenti' => 'integer',
);
}
