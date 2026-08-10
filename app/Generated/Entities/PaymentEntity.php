<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class PaymentEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'payment_date',
  1 => 'last_update',
);

    protected $casts = array (
  'payment_id' => 'integer',
  'customer_id' => 'integer',
  'staff_id' => 'integer',
  'rental_id' => 'integer',
  'amount' => 'float',
);
}
