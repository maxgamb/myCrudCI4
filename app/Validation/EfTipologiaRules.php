<?php

declare(strict_types=1);

namespace App\Validation;

final class EfTipologiaRules
{
    public static function createRules(): array
    {
        return array (
  'pax' => 'required|integer',
  4 => 'required|integer',
  3 => 'required|integer',
  2 => 'required|integer',
  1 => 'required|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'pax' => 'required|integer',
  4 => 'required|integer',
  3 => 'required|integer',
  2 => 'required|integer',
  1 => 'required|integer',
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
