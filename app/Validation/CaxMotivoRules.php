<?php

declare(strict_types=1);

namespace App\Validation;

final class CaxMotivoRules
{
    public static function createRules(): array
    {
        return array (
  'etichetta' => 'required|max_length[250]',
  'data' => 'permit_empty|valid_date',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'etichetta' => 'required|max_length[250]',
  'data' => 'permit_empty|valid_date',
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
