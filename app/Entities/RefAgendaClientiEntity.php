<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class RefAgendaClientiEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'ref_a_c_datarecord',
);

    protected $casts = array (
  'ref_agenda_cliente' => 'integer',
  'preno_id' => 'integer',
  'clienti_id' => 'integer',
  'tipologia_id' => 'integer',
);
}
