<?php

declare(strict_types=1);

namespace App\Validation;

final class ContiNoteRules
{
    public static function createRules(): array
    {
        return array (
  'conto_id' => 'permit_empty|integer|is_not_unique[conti.conto_id]',
  'hotel_id' => 'permit_empty|integer',
  'conto_nota_testo' => 'required',
  'note_conto_utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'conto_id' => 'permit_empty|integer|is_not_unique[conti.conto_id]',
  'hotel_id' => 'permit_empty|integer',
  'conto_nota_testo' => 'required',
  'note_conto_utente_id' => 'permit_empty|integer',
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
