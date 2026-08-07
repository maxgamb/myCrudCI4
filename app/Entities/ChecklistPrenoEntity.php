<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ChecklistPrenoEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'preno_dal',
  1 => 'data_check',
  2 => 'data_record',
);

    protected $casts = array (
  'checklist_id' => 'integer',
  'hotel_id' => 'integer',
  'preno_id' => 'integer',
  'email_pms' => 'integer',
  'lista' => 'integer',
  'lista_pms' => 'integer',
  'pagamento' => 'integer',
  'tassa' => 'integer',
  'proforma' => 'integer',
  'proforma_pms' => 'integer',
  'bonifico' => 'integer',
  'importo' => 'float',
  'utente_id' => 'integer',
);
}
