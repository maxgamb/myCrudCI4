<?php

declare(strict_types=1);

namespace App\Validation;

final class PrezziRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'permit_empty|integer',
  'conto_id' => 'permit_empty|integer',
  'prezzo_dal' => 'required|valid_date[Y-m-d]',
  'prezzo_al' => 'required|valid_date[Y-m-d]',
  'prezzo_valore' => 'permit_empty|decimal',
  'libero' => 'permit_empty|max_length[10]',
  'prezzi_utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'permit_empty|integer',
  'conto_id' => 'permit_empty|integer',
  'prezzo_dal' => 'required|valid_date[Y-m-d]',
  'prezzo_al' => 'required|valid_date[Y-m-d]',
  'prezzo_valore' => 'permit_empty|decimal',
  'libero' => 'permit_empty|max_length[10]',
  'prezzi_utente_id' => 'permit_empty|integer',
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
