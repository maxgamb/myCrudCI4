<?php

declare(strict_types=1);

namespace App\Validation;

final class AddressRules
{
    public static function createRules(): array
    {
        return array (
  'address' => 'required|max_length[50]',
  'address2' => 'permit_empty|max_length[50]',
  'district' => 'required|max_length[20]',
  'city_id' => 'required|integer|is_not_unique[city.city_id]',
  'postal_code' => 'permit_empty|max_length[10]',
  'phone' => 'required|max_length[20]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'address' => 'required|max_length[50]',
  'address2' => 'permit_empty|max_length[50]',
  'district' => 'required|max_length[20]',
  'city_id' => 'required|integer|is_not_unique[city.city_id]',
  'postal_code' => 'permit_empty|max_length[10]',
  'phone' => 'required|max_length[20]',
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
  'city_id' => 
  array (
    'city' => 'required|max_length[50]',
    'country_id' => 'required|integer|is_not_unique[country.country_id]',
  ),
);
    }

    public static function messages(): array
    {
        return [];
    }
}
