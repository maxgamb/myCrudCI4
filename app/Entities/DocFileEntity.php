<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class DocFileEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'doc_data_record',
);

    protected $casts = array (
  'doc_files_id' => 'integer',
  'hotel_id' => 'integer',
  'doc_dipar_id' => 'integer',
  'doc_protocollo' => 'integer',
  'doc_utente_id' => 'integer',
);
}
