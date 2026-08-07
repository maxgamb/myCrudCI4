<?php

declare(strict_types=1);

namespace App\Validation;

final class ProvinceRules
{
    public static function createRules(): array
    {
        return array (
  'Prov' => 'permit_empty|max_length[30]',
  'ColExcel' => 'permit_empty|max_length[30]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'Prov' => 'permit_empty|max_length[30]',
  'ColExcel' => 'permit_empty|max_length[30]',
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
