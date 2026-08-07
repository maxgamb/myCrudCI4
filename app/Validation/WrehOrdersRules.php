<?php

declare(strict_types=1);

namespace App\Validation;

final class WrehOrdersRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'permit_empty|integer',
  'order_date' => 'required|valid_date',
  'status' => 'permit_empty|max_length[50]',
  'utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'permit_empty|integer',
  'order_date' => 'required|valid_date',
  'status' => 'permit_empty|max_length[50]',
  'utente_id' => 'permit_empty|integer',
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
