<?php

declare(strict_types=1);

namespace App\Validation;

final class PagamentiSospesiRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'permit_empty|integer',
  'sospeso_id' => 'permit_empty|integer|is_not_unique[sospesi.sospeso_id]',
  'paga_sosp_importo' => 'permit_empty|decimal',
  'data_pagamento' => 'required|valid_date[Y-m-d]',
  'paga_modalita' => 'permit_empty|max_length[10]',
  'data_rec_paga_sosp' => 'permit_empty|valid_date',
  'pagamenti_sospesi_utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'permit_empty|integer',
  'sospeso_id' => 'permit_empty|integer|is_not_unique[sospesi.sospeso_id]',
  'paga_sosp_importo' => 'permit_empty|decimal',
  'data_pagamento' => 'required|valid_date[Y-m-d]',
  'paga_modalita' => 'permit_empty|max_length[10]',
  'data_rec_paga_sosp' => 'permit_empty|valid_date',
  'pagamenti_sospesi_utente_id' => 'permit_empty|integer',
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
