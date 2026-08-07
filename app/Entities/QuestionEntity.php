<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class QuestionEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'question_id' => 'integer',
  'tex_lingue_id_pro' => 'integer',
  'tex_lingue_id_con' => 'integer',
);
}
