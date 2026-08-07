<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class QuestionRewEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'data',
);

    protected $casts = array (
  'question_rew_id' => 'integer',
  'question_id' => 'integer',
  'hotel_id' => 'integer',
  'conto_id' => 'integer',
  'clienti_id' => 'integer',
);
}
