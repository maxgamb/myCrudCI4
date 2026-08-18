<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole server-side generate secondo le capability effettive del CRUD. */
final class CountryRules
{
    /** @return array<string,string> */
    public static function createRules(): array
    {
        return array (
  'country' => 'required|max_length[50]',
);
    }
    /** @return array<string,string> */
    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'country' => 'required|max_length[50]',
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
