<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole server-side generate secondo le capability effettive del CRUD. */
final class FilmTextRules
{
    /** @return array<string,string> */
    public static function createRules(): array
    {
        return array (
  'film_id' => 'required|integer',
  'title' => 'required|max_length[255]',
  'description' => 'permit_empty|max_length[65535]',
);
    }
    /** @return array<string,string> */
    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'film_id' => 'required|integer',
  'title' => 'required|max_length[255]',
  'description' => 'permit_empty|max_length[65535]',
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
