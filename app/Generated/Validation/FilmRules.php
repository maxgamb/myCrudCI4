<?php

declare(strict_types=1);

namespace App\Validation;

final class FilmRules
{
    public static function createRules(): array
    {
        return array (
  'title' => 'required|max_length[128]',
  'description' => 'permit_empty|max_length[65535]',
  'release_year' => 'permit_empty',
  'language_id' => 'required|integer|is_not_unique[language.language_id]',
  'original_language_id' => 'permit_empty|integer|is_not_unique[language.language_id]',
  'rental_duration' => 'required|integer',
  'rental_rate' => 'required|decimal',
  'length' => 'permit_empty|integer',
  'replacement_cost' => 'required|decimal',
  'rating' => 'permit_empty|max_length[5]',
  'special_features' => 'permit_empty|max_length[54]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'title' => 'required|max_length[128]',
  'description' => 'permit_empty|max_length[65535]',
  'release_year' => 'permit_empty',
  'language_id' => 'required|integer|is_not_unique[language.language_id]',
  'original_language_id' => 'permit_empty|integer|is_not_unique[language.language_id]',
  'rental_duration' => 'required|integer',
  'rental_rate' => 'required|decimal',
  'length' => 'permit_empty|integer',
  'replacement_cost' => 'required|decimal',
  'rating' => 'permit_empty|max_length[5]',
  'special_features' => 'permit_empty|max_length[54]',
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
  'language_id' => 
  array (
    'name' => 'required|max_length[20]',
  ),
  'original_language_id' => 
  array (
    'name' => 'required|max_length[20]',
  ),
);
    }

    public static function messages(): array
    {
        return [];
    }
}
