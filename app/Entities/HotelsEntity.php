<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class HotelsEntity extends Entity
{
    protected $datamap = [];

    protected $dates = array (
  0 => 'hotel_data_record',
);

    protected $casts = array (
  'hotel_id' => 'integer',
  'hotels_utente_id' => 'integer',
  'hotel_disp_modo' => 'integer',
  'hotel_limite_vendite_web' => 'integer',
  'hotel_limite_vendite_xml' => 'integer',
  'hotel_incremento_prezzo_xml' => 'float',
  'hotel_booking_attivazione' => 'integer',
  'hotel_booking_agenzia' => 'integer',
  'hotel_tarif_cambia_gg' => 'integer',
  'hotel_tarif_listino_nome_id' => 'integer',
  'hotel_agenzia_attivazione' => 'integer',
  'hotel_type_booking' => 'integer',
  'ae_test' => 'integer',
  'citytax' => 'float',
  'chek_email' => 'integer',
  'chek_tel' => 'integer',
);
}
