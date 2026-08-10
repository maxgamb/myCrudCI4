<?php

declare(strict_types=1);

namespace App\Validation;

final class FilmCategoryRules
{
    public static function createRules(): array
    {
        return array (
  'film_id' => 'required|integer|is_not_unique[film.film_id]',
  'category_id' => 'required|integer|is_not_unique[category.category_id]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'film_id' => 'required|integer|is_not_unique[film.film_id]',
  'category_id' => 'required|integer|is_not_unique[category.category_id]',
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
  'category_id' => 
  array (
    'name' => 'required|max_length[25]',
  ),
);
    }

    public static function messages(): array
    {
        return [];
    }
}
