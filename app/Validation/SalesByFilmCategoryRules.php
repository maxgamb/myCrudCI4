<?php

declare(strict_types=1);

namespace App\Validation;

final class SalesByFilmCategoryRules
{
    public static function createRules(): array
    {
        return array (
  'category' => 'required|max_length[25]',
  'total_sales' => 'permit_empty|decimal',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'category' => 'required|max_length[25]',
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
