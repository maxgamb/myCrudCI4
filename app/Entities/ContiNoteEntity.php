<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ContiNoteEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'conto_nota_data_record',
);

    protected $casts = array (
  'conto_nota_id' => 'integer',
  'conto_id' => 'integer',
  'hotel_id' => 'integer',
  'note_conto_utente_id' => 'integer',
);
}
