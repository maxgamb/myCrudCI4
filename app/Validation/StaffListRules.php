<?php

declare(strict_types=1);

namespace App\Validation;

final class StaffListRules
{
    public static function createRules(): array
    {
        return array (
  'ID' => 'permit_empty|integer',
  'name' => 'permit_empty|max_length[91]',
  'address' => 'required|max_length[50]',
  'zip code' => 'permit_empty|max_length[10]',
  'phone' => 'required|max_length[20]',
  'city' => 'required|max_length[50]',
  'country' => 'required|max_length[50]',
  'SID' => 'required|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'ID' => 'permit_empty|integer',
  'name' => 'permit_empty|max_length[91]',
  'address' => 'required|max_length[50]',
  'zip code' => 'permit_empty|max_length[10]',
  'phone' => 'required|max_length[20]',
  'city' => 'required|max_length[50]',
  'country' => 'required|max_length[50]',
  'SID' => 'required|integer',
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
