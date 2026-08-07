<?php

declare(strict_types=1);

namespace App\Validation;

final class SospesiRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'permit_empty|integer',
  'pagamento_id' => 'permit_empty|integer',
  'cassa_id' => 'required|integer',
  'sospeso_data' => 'required|valid_date[Y-m-d]',
  'sospeso_conto_id' => 'permit_empty|integer',
  'sospeso_pratica_id' => 'permit_empty|integer|is_not_unique[pratiche.pratica_id]',
  'sospeso_preno_id' => 'permit_empty|integer',
  'sospeso_fatt_numero' => 'permit_empty|integer',
  'sopeso_importo' => 'permit_empty|decimal',
  'sospeso_imp_conto' => 'required|decimal',
  'sopeso_societa' => 'permit_empty|integer|is_not_unique[agenzie.agenzia_id]',
  'sospeso_note' => 'permit_empty',
  'sospeso_stato' => 'permit_empty|integer',
  'sospesi_utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'permit_empty|integer',
  'pagamento_id' => 'permit_empty|integer',
  'cassa_id' => 'required|integer',
  'sospeso_data' => 'required|valid_date[Y-m-d]',
  'sospeso_conto_id' => 'permit_empty|integer',
  'sospeso_pratica_id' => 'permit_empty|integer|is_not_unique[pratiche.pratica_id]',
  'sospeso_preno_id' => 'permit_empty|integer',
  'sospeso_fatt_numero' => 'permit_empty|integer',
  'sopeso_importo' => 'permit_empty|decimal',
  'sospeso_imp_conto' => 'required|decimal',
  'sopeso_societa' => 'permit_empty|integer|is_not_unique[agenzie.agenzia_id]',
  'sospeso_note' => 'permit_empty',
  'sospeso_stato' => 'permit_empty|integer',
  'sospesi_utente_id' => 'permit_empty|integer',
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
