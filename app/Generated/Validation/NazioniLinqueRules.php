<?php

declare(strict_types=1);

namespace App\Validation;

final class NazioniLinqueRules
{
    public static function createRules(): array
    {
        return array (
  'isoKey' => 'required|max_length[5]',
  'iso3' => 'required|max_length[5]',
  'nazioni_EN' => 'required|max_length[100]',
  'nazioni_ES' => 'required|max_length[100]',
  'nazioni_FR' => 'required|max_length[100]',
  'nazioni_DE' => 'required|max_length[100]',
  'nazioni_IT' => 'required|max_length[100]',
  'lg' => 'required|max_length[4]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'isoKey' => 'required|max_length[5]',
  'iso3' => 'required|max_length[5]',
  'nazioni_EN' => 'required|max_length[100]',
  'nazioni_ES' => 'required|max_length[100]',
  'nazioni_FR' => 'required|max_length[100]',
  'nazioni_DE' => 'required|max_length[100]',
  'nazioni_IT' => 'required|max_length[100]',
  'lg' => 'required|max_length[4]',
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
