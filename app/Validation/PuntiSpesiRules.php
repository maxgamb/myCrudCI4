<?php

declare(strict_types=1);

namespace App\Validation;

final class PuntiSpesiRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'required|integer',
  'cliente_id' => 'required|integer|is_not_unique[clienti.clienti_id]',
  'conto_id' => 'required|integer|is_not_unique[conti.conto_id]',
  'punti' => 'required|integer',
  'data' => 'required|valid_date[Y-m-d]',
  'utente_id' => 'required|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'required|integer',
  'cliente_id' => 'required|integer|is_not_unique[clienti.clienti_id]',
  'conto_id' => 'required|integer|is_not_unique[conti.conto_id]',
  'punti' => 'required|integer',
  'data' => 'required|valid_date[Y-m-d]',
  'utente_id' => 'required|integer',
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
