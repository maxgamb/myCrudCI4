<?php

declare(strict_types=1);

namespace App\Validation;

final class TexLingueRules
{
    public static function createRules(): array
    {
        return array (
  'etichetta_lg' => 'required|max_length[255]',
  'en' => 'required',
  'it' => 'required',
  'es' => 'required',
  'fr' => 'required',
  'de' => 'required',
  'reparto_id' => 'permit_empty|max_length[50]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'etichetta_lg' => 'required|max_length[255]',
  'en' => 'required',
  'it' => 'required',
  'es' => 'required',
  'fr' => 'required',
  'de' => 'required',
  'reparto_id' => 'permit_empty|max_length[50]',
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
