<?php

declare(strict_types=1);

namespace App\Validation;

final class ReferClientiRules
{
    public static function createRules(): array
    {
        return array (
  'conto_id' => 'required|integer|is_not_unique[conti.conto_id]',
  'clienti_id' => 'required|integer',
  'hotel_id' => 'required|integer',
  'ps_valore' => 'required|integer',
  'refer_clienti_utente_id' => 'permit_empty|integer',
  'refer_clienti_conto_id' => 'required|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'conto_id' => 'required|integer|is_not_unique[conti.conto_id]',
  'clienti_id' => 'required|integer',
  'hotel_id' => 'required|integer',
  'ps_valore' => 'required|integer',
  'refer_clienti_utente_id' => 'permit_empty|integer',
  'refer_clienti_conto_id' => 'required|integer',
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
