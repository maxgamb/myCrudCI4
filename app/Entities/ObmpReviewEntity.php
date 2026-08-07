<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ObmpReviewEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'data_review',
  1 => 'review_data_record',
);

    protected $casts = array (
  'review_id' => 'integer',
  'hotel_id' => 'integer',
  'preno_id' => 'integer',
  'conto_id' => 'integer',
  'postazione_id' => 'integer',
  'camera_numero' => 'integer',
  'user_type' => 'integer',
  'pulizia_camera' => 'integer',
  'accoglienza' => 'integer',
  'rumore_camere' => 'integer',
  'spazio_camera' => 'integer',
  'spazi_comuni' => 'integer',
  'competenza_impiegati' => 'integer',
  'qualita_servizi' => 'integer',
  'dintorni' => 'integer',
  'colazione' => 'integer',
  'tariffa' => 'integer',
  'servizi_offerti' => 'integer',
  'foto' => 'integer',
  'indicazione_mappa' => 'integer',
  'giudizio_totale' => 'integer',
  'prezzo_qualita' => 'integer',
  'raccomandi' => 'integer',
);
}
