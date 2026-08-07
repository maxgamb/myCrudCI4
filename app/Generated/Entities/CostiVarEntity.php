<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CostiVarEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
);

    protected $casts = array (
  'costi_var_id' => 'integer',
  'costi_area_id' => 'integer',
  'hotel_id' => 'integer',
  'costi_var_codice' => 'integer',
  'costi_var_deposito' => 'float',
  'mag_quantita' => 'integer',
  'costi_var_prezzo_uso' => 'float',
  'mag_prezzo_lavaggio' => 'float',
  'costi_var_addebbito' => 'float',
);
}
