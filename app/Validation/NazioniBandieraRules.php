<?php

declare(strict_types=1);

namespace App\Validation;

final class NazioniBandieraRules
{
    public static function createRules(): array
    {
        return array (
  'nazione_iso2' => 'permit_empty|exact_length[4]',
  'Nazioni_Codice' => 'required|integer',
  'emoji' => 'permit_empty|max_length[8]',
  'cod_emoji' => 'permit_empty|max_length[18]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'nazione_iso2' => 'permit_empty|exact_length[4]',
  'Nazioni_Codice' => 'required|integer',
  'emoji' => 'permit_empty|max_length[8]',
  'cod_emoji' => 'permit_empty|max_length[18]',
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
