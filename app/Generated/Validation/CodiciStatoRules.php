<?php

declare(strict_types=1);

namespace App\Validation;

final class CodiciStatoRules
{
    public static function createRules(): array
    {
        return array (
  'cod_stato' => 'permit_empty|exact_length[3]',
  'stato' => 'permit_empty|max_length[100]',
  'stato_commento' => 'permit_empty|max_length[200]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'cod_stato' => 'permit_empty|exact_length[3]',
  'stato' => 'permit_empty|max_length[100]',
  'stato_commento' => 'permit_empty|max_length[200]',
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
