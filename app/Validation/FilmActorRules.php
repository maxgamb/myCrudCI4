<?php

declare(strict_types=1);

namespace App\Validation;

final class FilmActorRules
{
    public static function createRules(): array
    {
        return array (
  'actor_id' => 'required|integer|is_not_unique[actor.actor_id]',
  'film_id' => 'required|integer|is_not_unique[film.film_id]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'actor_id' => 'required|integer|is_not_unique[actor.actor_id]',
  'film_id' => 'required|integer|is_not_unique[film.film_id]',
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
  'actor_id' => 
  array (
    'first_name' => 'required|max_length[45]',
    'last_name' => 'required|max_length[45]',
  ),
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
  ),
);
    }

    public static function messages(): array
    {
        return [];
    }
}
