<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ObmpBoardEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'obmp_board_id' => 'integer',
);
}
