<?php

declare(strict_types=1);

namespace App\Validation;

final class PraticheRifRules
{
    public static function createRules(): array
    {
        return array (
  'pratica_rif_pratica_id' => 'permit_empty|integer',
  'hotel_id' => 'permit_empty|integer',
  'pratica_rif_conto_id' => 'permit_empty|integer',
  'pratica_rif_totale_modificato' => 'permit_empty|decimal',
  'pratica_rif_totale_importo' => 'permit_empty|decimal',
  'pratica_rif_pagamento_importo_pag' => 'permit_empty|decimal',
  'pratica_rif_note' => 'permit_empty',
  'pratica_rif_out_conto' => 'required|valid_date[Y-m-d]',
  'pratiche_rif_id' => 'permit_empty|integer|is_not_unique[pratiche.pratica_id]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'pratica_rif_pratica_id' => 'permit_empty|integer',
  'hotel_id' => 'permit_empty|integer',
  'pratica_rif_conto_id' => 'permit_empty|integer',
  'pratica_rif_totale_modificato' => 'permit_empty|decimal',
  'pratica_rif_totale_importo' => 'permit_empty|decimal',
  'pratica_rif_pagamento_importo_pag' => 'permit_empty|decimal',
  'pratica_rif_note' => 'permit_empty',
  'pratica_rif_out_conto' => 'required|valid_date[Y-m-d]',
  'pratiche_rif_id' => 'permit_empty|integer|is_not_unique[pratiche.pratica_id]',
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
