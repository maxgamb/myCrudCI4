<?php

declare(strict_types=1);

namespace App\Validation;

final class LettereRules
{
    public static function createRules(): array
    {
        return array (
  'etichetta' => 'required|max_length[50]',
  'hotel_id' => 'required|integer',
  'titolo' => 'required|max_length[100]',
  'reparto' => 'required|max_length[50]',
  'contoller' => 'required|max_length[100]',
  'en' => 'required',
  'it' => 'required',
  'es' => 'required',
  'fr' => 'required',
  'de' => 'required',
  'data_stamp' => 'permit_empty|valid_date',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'etichetta' => 'required|max_length[50]',
  'hotel_id' => 'required|integer',
  'titolo' => 'required|max_length[100]',
  'reparto' => 'required|max_length[50]',
  'contoller' => 'required|max_length[100]',
  'en' => 'required',
  'it' => 'required',
  'es' => 'required',
  'fr' => 'required',
  'de' => 'required',
  'data_stamp' => 'permit_empty|valid_date',
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
