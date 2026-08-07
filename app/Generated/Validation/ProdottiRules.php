<?php

declare(strict_types=1);

namespace App\Validation;

final class ProdottiRules
{
    public static function createRules(): array
    {
        return array (
  'prodotti_lista_id' => 'required|integer',
  'hotel_id' => 'permit_empty|integer',
  'nome_prodotto' => 'permit_empty|max_length[100]',
  'prezzo_prodotto' => 'permit_empty|decimal',
  'tipologia_prodotto' => 'permit_empty|max_length[100]',
  'reparto_prodotto' => 'permit_empty|max_length[100]',
  'cent_costo_prodotto' => 'permit_empty|decimal',
  'prodotti_utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'prodotti_lista_id' => 'required|integer',
  'hotel_id' => 'permit_empty|integer',
  'nome_prodotto' => 'permit_empty|max_length[100]',
  'prezzo_prodotto' => 'permit_empty|decimal',
  'tipologia_prodotto' => 'permit_empty|max_length[100]',
  'reparto_prodotto' => 'permit_empty|max_length[100]',
  'cent_costo_prodotto' => 'permit_empty|decimal',
  'prodotti_utente_id' => 'permit_empty|integer',
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
