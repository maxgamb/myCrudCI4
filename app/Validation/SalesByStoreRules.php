<?php

declare(strict_types=1);

namespace App\Validation;

final class SalesByStoreRules
{
    public static function createRules(): array
    {
        return array (
  'store' => 'permit_empty|max_length[101]',
  'manager' => 'permit_empty|max_length[91]',
  'total_sales' => 'permit_empty|decimal',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'store' => 'permit_empty|max_length[101]',
  'manager' => 'permit_empty|max_length[91]',
  'total_sales' => 'permit_empty|decimal',
);
        foreach ($rules as $field => $rule) {
            $rules[$field] = str_replace('{id}', (string) $id, $rule);
        }
        return $rules;
    }

    /** Regole dei record padre creati nello stesso submit. */
    public static function relatedCreateRules(): array
    {
        return array (
);
    }

    public static function messages(): array
    {
        return [];
    }
}
