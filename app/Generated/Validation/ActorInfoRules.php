<?php

declare(strict_types=1);

namespace App\Validation;

final class ActorInfoRules
{
    public static function createRules(): array
    {
        return array (
  'actor_id' => 'permit_empty|integer',
  'first_name' => 'required|max_length[45]',
  'last_name' => 'required|max_length[45]',
  'film_info' => 'permit_empty|max_length[65535]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'actor_id' => 'permit_empty|integer',
  'first_name' => 'required|max_length[45]',
  'last_name' => 'required|max_length[45]',
  'film_info' => 'permit_empty|max_length[65535]',
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
