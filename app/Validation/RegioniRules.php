<?php

declare(strict_types=1);

namespace App\Validation;

final class RegioniRules
{
    public static function createRules(): array
    {
        return array (
  'cod_provincia' => 'required|max_length[5]',
  'provincia' => 'required|max_length[100]',
  'regione' => 'required|max_length[100]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'cod_provincia' => 'required|max_length[5]',
  'provincia' => 'required|max_length[100]',
  'regione' => 'required|max_length[100]',
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
