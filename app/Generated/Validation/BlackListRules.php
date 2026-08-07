<?php

declare(strict_types=1);

namespace App\Validation;

final class BlackListRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'permit_empty|integer',
  'clienti_id' => 'permit_empty|integer',
  'black_list_stato' => 'permit_empty|integer',
  'black_list_data' => 'permit_empty|valid_date',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'permit_empty|integer',
  'clienti_id' => 'permit_empty|integer',
  'black_list_stato' => 'permit_empty|integer',
  'black_list_data' => 'permit_empty|valid_date',
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
