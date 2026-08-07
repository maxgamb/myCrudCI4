<?php

declare(strict_types=1);

namespace App\Validation;

final class ObmpRestrictionsRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'permit_empty|max_length[45]',
  'restr_nama' => 'permit_empty|max_length[45]',
  'restr_min_stay' => 'permit_empty|integer',
  'restr_max_stay' => 'permit_empty|integer',
  'restr_min_bw' => 'permit_empty|integer',
  'restr_max_bw' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'permit_empty|max_length[45]',
  'restr_nama' => 'permit_empty|max_length[45]',
  'restr_min_stay' => 'permit_empty|integer',
  'restr_max_stay' => 'permit_empty|integer',
  'restr_min_bw' => 'permit_empty|integer',
  'restr_max_bw' => 'permit_empty|integer',
);
        foreach ($rules as $field => $rule) {
            $rules[$field] = str_replace('{id}', (string) $id, $rule);
        }
        return $rules;
    }

    public static function messages(): array
    {
        return [];
    }
}
