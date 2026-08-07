<?php

declare(strict_types=1);

namespace App\Validation;

final class PuliziaRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'required|integer',
  'conto_id' => 'required|integer|is_not_unique[conti.conto_id]',
  'camera_id' => 'required|integer',
  'cambio_biancheria' => 'permit_empty|integer',
  'pulizia_stato' => 'required|integer',
  'pulizia_data' => 'permit_empty|valid_date[Y-m-d]',
  'pulizia_note' => 'permit_empty|max_length[255]',
  'utente_id' => 'required|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'required|integer',
  'conto_id' => 'required|integer|is_not_unique[conti.conto_id]',
  'camera_id' => 'required|integer',
  'cambio_biancheria' => 'permit_empty|integer',
  'pulizia_stato' => 'required|integer',
  'pulizia_data' => 'permit_empty|valid_date[Y-m-d]',
  'pulizia_note' => 'permit_empty|max_length[255]',
  'utente_id' => 'required|integer',
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
