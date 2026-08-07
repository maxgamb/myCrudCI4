<?php

declare(strict_types=1);

namespace App\Validation;

final class TokenRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'required|integer',
  'token' => 'required|max_length[250]',
  'token_data' => 'required|valid_date[Y-m-d]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'required|integer',
  'token' => 'required|max_length[250]',
  'token_data' => 'required|valid_date[Y-m-d]',
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
