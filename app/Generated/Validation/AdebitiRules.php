<?php

declare(strict_types=1);

namespace App\Validation;

final class AdebitiRules
{
    public static function createRules(): array
    {
        return array (
  'conto_id' => 'required|integer|is_unique[adebiti.conto_id]',
  'hotel_id' => 'required|integer',
  'prodotto_id' => 'required|integer|is_not_unique[prodotti.prodotto_id]',
  'descrizione' => 'permit_empty|max_length[100]',
  'prezzo' => 'required|decimal',
  'quantita' => 'required|integer',
  'adebiti_utente_id' => 'permit_empty|integer',
  'preno_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'conto_id' => 'required|integer|is_unique[adebiti.conto_id,adebito_id,{id}]',
  'hotel_id' => 'required|integer',
  'prodotto_id' => 'required|integer|is_not_unique[prodotti.prodotto_id]',
  'descrizione' => 'permit_empty|max_length[100]',
  'prezzo' => 'required|decimal',
  'quantita' => 'required|integer',
  'adebiti_utente_id' => 'permit_empty|integer',
  'preno_id' => 'permit_empty|integer',
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
