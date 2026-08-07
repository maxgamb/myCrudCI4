<?php

declare(strict_types=1);

namespace App\Validation;

final class CamereRules
{
    public static function createRules(): array
    {
        return array (
  'camera_id' => 'required|integer',
  'hotel_id' => 'permit_empty|integer',
  'numero_camera' => 'permit_empty|integer',
  'tipologia_camera' => 'permit_empty|max_length[100]',
  'tipologia_id' => 'permit_empty|integer|is_not_unique[tipologia_camera.tipologia_id]',
  'camere_max_pax' => 'permit_empty|integer',
  'camere_metri_quadri' => 'permit_empty|decimal',
  'camere_vista' => 'permit_empty|max_length[100]',
  'camere_piano' => 'permit_empty|decimal',
  'camere_bagno' => 'permit_empty|max_length[100]',
  'camere_edificio' => 'permit_empty|exact_length[3]',
  'review_tot' => 'permit_empty|decimal',
  'camere_utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'camera_id' => 'required|integer',
  'hotel_id' => 'permit_empty|integer',
  'numero_camera' => 'permit_empty|integer',
  'tipologia_camera' => 'permit_empty|max_length[100]',
  'tipologia_id' => 'permit_empty|integer|is_not_unique[tipologia_camera.tipologia_id]',
  'camere_max_pax' => 'permit_empty|integer',
  'camere_metri_quadri' => 'permit_empty|decimal',
  'camere_vista' => 'permit_empty|max_length[100]',
  'camere_piano' => 'permit_empty|decimal',
  'camere_bagno' => 'permit_empty|max_length[100]',
  'camere_edificio' => 'permit_empty|exact_length[3]',
  'review_tot' => 'permit_empty|decimal',
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
