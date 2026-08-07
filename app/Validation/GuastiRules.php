<?php

declare(strict_types=1);

namespace App\Validation;

final class GuastiRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'required|integer|is_not_unique[hotels.hotel_id]',
  'camera_id' => 'permit_empty|integer|is_not_unique[camere.camera_id]',
  'guasto_priorita' => 'permit_empty|integer',
  'guasto_area' => 'permit_empty|max_length[250]',
  'guasto_piano' => 'permit_empty|max_length[250]',
  'guasto_note' => 'permit_empty|max_length[250]',
  'guasto_stato' => 'permit_empty|integer',
  'guasto_data' => 'permit_empty|valid_date[Y-m-d]',
  'guasto_utente_id' => 'required|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'required|integer|is_not_unique[hotels.hotel_id]',
  'camera_id' => 'permit_empty|integer|is_not_unique[camere.camera_id]',
  'guasto_priorita' => 'permit_empty|integer',
  'guasto_area' => 'permit_empty|max_length[250]',
  'guasto_piano' => 'permit_empty|max_length[250]',
  'guasto_note' => 'permit_empty|max_length[250]',
  'guasto_stato' => 'permit_empty|integer',
  'guasto_data' => 'permit_empty|valid_date[Y-m-d]',
  'guasto_utente_id' => 'required|integer',
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
