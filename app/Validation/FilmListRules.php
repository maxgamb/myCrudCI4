<?php

declare(strict_types=1);

namespace App\Validation;

final class FilmListRules
{
    public static function createRules(): array
    {
        return array (
  'FID' => 'permit_empty|integer',
  'title' => 'required|max_length[128]',
  'description' => 'permit_empty|max_length[65535]',
  'category' => 'permit_empty|max_length[25]',
  'price' => 'permit_empty|decimal',
  'length' => 'permit_empty|integer',
  'rating' => 'permit_empty|max_length[5]',
  'actors' => 'permit_empty|max_length[65535]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'FID' => 'permit_empty|integer',
  'title' => 'required|max_length[128]',
  'description' => 'permit_empty|max_length[65535]',
  'category' => 'permit_empty|max_length[25]',
  'price' => 'permit_empty|decimal',
  'length' => 'permit_empty|integer',
  'rating' => 'permit_empty|max_length[5]',
  'actors' => 'permit_empty|max_length[65535]',
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
