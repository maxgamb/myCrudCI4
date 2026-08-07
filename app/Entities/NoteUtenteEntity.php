<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class NoteUtenteEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'note_utente_dal',
  1 => 'note_utente_al',
  2 => 'note_utente_data',
  3 => 'note_utente_data_record',
);

    protected $casts = array (
  'note_utente_id' => 'integer',
  'note_utente_rispondi_id' => 'integer',
  'Utente_id' => 'integer',
  'hotel_id' => 'integer',
  'reparto' => 'integer',
  'note_utente_per' => 'integer',
  'note_utente_stato' => 'integer',
);
}
