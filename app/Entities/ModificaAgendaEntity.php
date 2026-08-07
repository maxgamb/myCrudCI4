<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ModificaAgendaEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'mod_preno_data_records',
);

    protected $casts = array (
  'mod_agenda_id' => 'integer',
  'mod_preno_id' => 'integer',
  'modifica_agenda_adebiti_utente_id' => 'integer',
);
}
