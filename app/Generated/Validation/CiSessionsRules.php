<?php

declare(strict_types=1);

namespace App\Validation;

final class CiSessionsRules
{
    public static function createRules(): array
    {
        return array (
  'id' => 'required|max_length[128]',
  'ip_address' => 'required|max_length[45]',
  'timestamp' => 'permit_empty|integer',
  'data' => 'required|max_length[65535]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'id' => 'required|max_length[128]',
  'ip_address' => 'required|max_length[45]',
  'timestamp' => 'permit_empty|integer',
  'data' => 'required|max_length[65535]',
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
