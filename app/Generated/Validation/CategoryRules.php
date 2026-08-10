<?php

declare(strict_types=1);

namespace App\Validation;

final class CategoryRules
{
    public static function createRules(): array
    {
        return array (
  'name' => 'required|max_length[25]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'name' => 'required|max_length[25]',
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
