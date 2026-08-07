<?php

declare(strict_types=1);

namespace App\Validation;

final class TaxPagamentoRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'required|integer',
  'conto_id' => 'permit_empty|integer|is_not_unique[conti.conto_id]',
  'pratica_id' => 'permit_empty|integer',
  'importo' => 'permit_empty|decimal',
  'pagamento_forma' => 'required|max_length[5]',
  'tassa_stato' => 'required|integer',
  'data_pagamento' => 'required|valid_date[Y-m-d]',
  'tax_pagamento_utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'required|integer',
  'conto_id' => 'permit_empty|integer|is_not_unique[conti.conto_id]',
  'pratica_id' => 'permit_empty|integer',
  'importo' => 'permit_empty|decimal',
  'pagamento_forma' => 'required|max_length[5]',
  'tassa_stato' => 'required|integer',
  'data_pagamento' => 'required|valid_date[Y-m-d]',
  'tax_pagamento_utente_id' => 'permit_empty|integer',
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
