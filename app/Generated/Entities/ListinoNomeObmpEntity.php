<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ListinoNomeObmpEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'listino_nome_datarecord',
);

    protected $casts = array (
  'listino_nome_id' => 'integer',
  'hotel_id' => 'integer',
  'yield' => 'integer',
);
}
