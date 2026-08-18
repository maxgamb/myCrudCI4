<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole server-side generate secondo le capability effettive del CRUD. */
final class InventoryRules
{
    /** @return array<string,string> */
    public static function createRules(): array
    {
        return array (
  'film_id' => 'required|integer|is_not_unique[film.film_id]',
  'store_id' => 'required|integer|is_not_unique[store.store_id]',
);
    }
    /** @return array<string,string> */
    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'film_id' => 'required|integer|is_not_unique[film.film_id]',
  'store_id' => 'required|integer|is_not_unique[store.store_id]',
);
        foreach ($rules as $field => $rule) {
            $rules[$field] = str_replace('{id}', (string) $id, $rule);
        }
        return $rules;
    }
    /** @return array<string,array<string,string>> */
    public static function relatedCreateRules(): array
    {
        return array (
  'film_id' =>
  array (
    'title' => 'required|max_length[128]',
    'description' => 'permit_empty|max_length[65535]',
    'release_year' => 'permit_empty',
    'language_id' => 'required|integer|is_not_unique[language.language_id]',
    'original_language_id' => 'permit_empty|integer|is_not_unique[language.language_id]',
    'rental_duration' => 'permit_empty|integer',
    'rental_rate' => 'permit_empty|decimal',
    'length' => 'permit_empty|integer',
    'replacement_cost' => 'permit_empty|decimal',
    'rating' => 'permit_empty|max_length[5]',
    'special_features' => 'permit_empty|max_length[54]',
    'uploads' => 'permit_empty|max_length[200]',
  ),
  'store_id' =>
  array (
    'manager_staff_id' => 'required|integer|is_not_unique[staff.staff_id]|is_unique[store.manager_staff_id]',
    'address_id' => 'required|integer|is_not_unique[address.address_id]',
  ),
);
    }

    /** @return array<string,array<string,string>> */
    public static function manyToManyRelatedCreateRules(): array
    {
        return array (
);
    }
    /** @return array<string,string> */
    public static function messages(): array
    {
        return [];
    }
}
