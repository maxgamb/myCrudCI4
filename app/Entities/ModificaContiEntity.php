<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ModificaContiEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'mod_in_conto',
  1 => 'mod_out_preno',
  2 => 'mod_out_conto',
  3 => 'mod_data_record',
);

    protected $casts = array (
  'id_mod_conto' => 'integer',
  'mod_conto_id' => 'integer',
  'mod_hotel_id' => 'integer',
  'mod_foglio_id' => 'integer',
  'mod_clienti_id' => 'integer',
  'mod_preno_id' => 'integer',
  'mod_camera_id' => 'integer',
  'mod_numero_camera' => 'integer',
  'mod_preno_agenzia' => 'integer',
  'modifica_conti_adebiti_utente_id' => 'integer',
);
}
