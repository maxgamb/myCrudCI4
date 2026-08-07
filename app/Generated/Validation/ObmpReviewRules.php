<?php

declare(strict_types=1);

namespace App\Validation;

final class ObmpReviewRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'permit_empty|integer',
  'preno_id' => 'permit_empty|integer',
  'conto_id' => 'required|integer|is_not_unique[conti.conto_id]|is_unique[obmp_review.conto_id]',
  'postazione_id' => 'permit_empty|integer',
  'camera_numero' => 'permit_empty|integer',
  'nome' => 'permit_empty|max_length[250]',
  'stato' => 'permit_empty|max_length[250]',
  'user_type' => 'permit_empty|integer',
  'pulizia_camera' => 'permit_empty|integer',
  'accoglienza' => 'permit_empty|integer',
  'rumore_camere' => 'permit_empty|integer',
  'spazio_camera' => 'permit_empty|integer',
  'spazi_comuni' => 'permit_empty|integer',
  'competenza_impiegati' => 'permit_empty|integer',
  'qualita_servizi' => 'permit_empty|integer',
  'dintorni' => 'permit_empty|integer',
  'colazione' => 'permit_empty|integer',
  'tariffa' => 'permit_empty|integer',
  'servizi_offerti' => 'permit_empty|integer',
  'foto' => 'permit_empty|integer',
  'indicazione_mappa' => 'permit_empty|integer',
  'giudizio_totale' => 'permit_empty|integer',
  'prezzo_qualita' => 'permit_empty|integer',
  'commento_tex' => 'permit_empty',
  'risposta' => 'permit_empty',
  'raccomandi' => 'permit_empty|integer',
  'ip_review' => 'permit_empty|max_length[250]',
  'data_review' => 'permit_empty|valid_date[Y-m-d]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'permit_empty|integer',
  'preno_id' => 'permit_empty|integer',
  'conto_id' => 'required|integer|is_not_unique[conti.conto_id]|is_unique[obmp_review.conto_id,review_id,{id}]',
  'postazione_id' => 'permit_empty|integer',
  'camera_numero' => 'permit_empty|integer',
  'nome' => 'permit_empty|max_length[250]',
  'stato' => 'permit_empty|max_length[250]',
  'user_type' => 'permit_empty|integer',
  'pulizia_camera' => 'permit_empty|integer',
  'accoglienza' => 'permit_empty|integer',
  'rumore_camere' => 'permit_empty|integer',
  'spazio_camera' => 'permit_empty|integer',
  'spazi_comuni' => 'permit_empty|integer',
  'competenza_impiegati' => 'permit_empty|integer',
  'qualita_servizi' => 'permit_empty|integer',
  'dintorni' => 'permit_empty|integer',
  'colazione' => 'permit_empty|integer',
  'tariffa' => 'permit_empty|integer',
  'servizi_offerti' => 'permit_empty|integer',
  'foto' => 'permit_empty|integer',
  'indicazione_mappa' => 'permit_empty|integer',
  'giudizio_totale' => 'permit_empty|integer',
  'prezzo_qualita' => 'permit_empty|integer',
  'commento_tex' => 'permit_empty',
  'risposta' => 'permit_empty',
  'raccomandi' => 'permit_empty|integer',
  'ip_review' => 'permit_empty|max_length[250]',
  'data_review' => 'permit_empty|valid_date[Y-m-d]',
);
        foreach ($rules as $field => $rule) {
            $rules[$field] = str_replace('{id}', (string) $id, $rule);
        }
        return $rules;
    }

    public static function messages(): array
    {
        return [];
    }
}
