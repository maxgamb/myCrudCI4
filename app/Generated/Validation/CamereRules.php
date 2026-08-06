<?php

namespace App\Validation;

final class CamereRules
{
    public static function createRules(): array
    {
        return array (
  'camera_id' => 'required|integer',
  'hotel_id' => 'required|integer',
  'numero_camera' => 'required|integer',
  'tipologia_camera' => 'required|max_length[100]',
  'tipologia_id' => 'required|integer',
  'camere_max_pax' => 'permit_empty|integer',
  'camere_metri_quadri' => 'permit_empty|decimal',
  'camere_vista' => 'permit_empty|max_length[100]',
  'camere_piano' => 'permit_empty|decimal',
  'camere_bagno' => 'permit_empty|max_length[100]',
  'camere_edificio' => 'permit_empty|max_length[3]',
  'review_tot' => 'permit_empty|decimal',
  'camere_data_record' => 'required|valid_date',
  'camere_utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'camera_id' => 'required|integer',
  'hotel_id' => 'required|integer',
  'numero_camera' => 'required|integer',
  'tipologia_camera' => 'required|max_length[100]',
  'tipologia_id' => 'required|integer',
  'camere_max_pax' => 'permit_empty|integer',
  'camere_metri_quadri' => 'permit_empty|decimal',
  'camere_vista' => 'permit_empty|max_length[100]',
  'camere_piano' => 'permit_empty|decimal',
  'camere_bagno' => 'permit_empty|max_length[100]',
  'camere_edificio' => 'permit_empty|max_length[3]',
  'review_tot' => 'permit_empty|decimal',
  'camere_data_record' => 'required|valid_date',
  'camere_utente_id' => 'permit_empty|integer',
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
