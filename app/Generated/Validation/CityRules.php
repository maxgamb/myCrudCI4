<?php

declare(strict_types=1);

namespace App\Validation;

final class CityRules
{
    public static function createRules(): array
    {
        return array (
  'city' => 'required|max_length[50]',
  'country_id' => 'required|integer|is_not_unique[country.country_id]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'city' => 'required|max_length[50]',
  'country_id' => 'required|integer|is_not_unique[country.country_id]',
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
  'country_id' => 
  array (
    'country' => 'required|max_length[50]',
  ),
);
    }

    public static function messages(): array
    {
        return [];
    }
}
