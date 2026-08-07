<?php

declare(strict_types=1);

namespace App\Validation;

final class ManutenzioniRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'permit_empty|integer',
  'manut_priorita' => 'permit_empty|max_length[10]',
  'manut_area_guasto' => 'permit_empty|max_length[10]',
  'manut_piano' => 'permit_empty|max_length[10]',
  'manut_camera' => 'permit_empty|max_length[10]',
  'manut_descrizione' => 'permit_empty',
  'manut_data_segnalazione' => 'required|valid_date[Y-m-d]',
  'manut_stato' => 'permit_empty|exact_length[2]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'permit_empty|integer',
  'manut_priorita' => 'permit_empty|max_length[10]',
  'manut_area_guasto' => 'permit_empty|max_length[10]',
  'manut_piano' => 'permit_empty|max_length[10]',
  'manut_camera' => 'permit_empty|max_length[10]',
  'manut_descrizione' => 'permit_empty',
  'manut_data_segnalazione' => 'required|valid_date[Y-m-d]',
  'manut_stato' => 'permit_empty|exact_length[2]',
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
