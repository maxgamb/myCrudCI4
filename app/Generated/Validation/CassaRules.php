<?php

declare(strict_types=1);

namespace App\Validation;

final class CassaRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'permit_empty|integer',
  'preno_id' => 'permit_empty|integer|is_not_unique[agenda.preno_id]',
  'out_conto' => 'permit_empty|valid_date[Y-m-d]',
  'conto_id' => 'permit_empty|integer',
  'totale_importo' => 'permit_empty|decimal',
  'totale_modificato' => 'permit_empty|decimal',
  'pagamento_importo_pag' => 'permit_empty|decimal',
  'pagamento_forma' => 'permit_empty|exact_length[3]',
  'cassa_stato_camera' => 'permit_empty|exact_length[3]',
  'sospeso' => 'permit_empty|exact_length[2]',
  'fattura_numero' => 'permit_empty|integer',
  'nome_pagante' => 'permit_empty|max_length[100]',
  'cassa_utente_id' => 'permit_empty|integer',
  'divisa' => 'permit_empty|max_length[50]',
  'nexi_cod_aut' => 'permit_empty|max_length[50]',
  'nexi_codTrans' => 'permit_empty|max_length[100]',
  'nexi_pan' => 'permit_empty|max_length[100]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'permit_empty|integer',
  'preno_id' => 'permit_empty|integer|is_not_unique[agenda.preno_id]',
  'out_conto' => 'permit_empty|valid_date[Y-m-d]',
  'conto_id' => 'permit_empty|integer',
  'totale_importo' => 'permit_empty|decimal',
  'totale_modificato' => 'permit_empty|decimal',
  'pagamento_importo_pag' => 'permit_empty|decimal',
  'pagamento_forma' => 'permit_empty|exact_length[3]',
  'cassa_stato_camera' => 'permit_empty|exact_length[3]',
  'sospeso' => 'permit_empty|exact_length[2]',
  'fattura_numero' => 'permit_empty|integer',
  'nome_pagante' => 'permit_empty|max_length[100]',
  'cassa_utente_id' => 'permit_empty|integer',
  'divisa' => 'permit_empty|max_length[50]',
  'nexi_cod_aut' => 'permit_empty|max_length[50]',
  'nexi_codTrans' => 'permit_empty|max_length[100]',
  'nexi_pan' => 'permit_empty|max_length[100]',
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
