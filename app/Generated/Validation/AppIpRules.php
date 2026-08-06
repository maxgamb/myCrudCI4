<?php

namespace App\Validation;

final class AppIpRules
{
    public static function createRules(): array
    {
        return array (
  'ip_aderss' => 'required|max_length[200]',
  'Livello' => 'required|integer',
  'data' => 'required|valid_date',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'ip_aderss' => 'required|max_length[200]',
  'Livello' => 'required|integer',
  'data' => 'required|valid_date',
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
