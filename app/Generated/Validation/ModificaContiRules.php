<?php

declare(strict_types=1);

namespace App\Validation;

final class ModificaContiRules
{
    public static function createRules(): array
    {
        return array (
  'mod_conto_id' => 'permit_empty|integer|is_not_unique[conti.conto_id]',
  'mod_hotel_id' => 'permit_empty|integer',
  'mod_foglio_id' => 'permit_empty|integer',
  'mod_clienti_id' => 'permit_empty|integer',
  'mod_in_conto' => 'required|valid_date[Y-m-d]',
  'mod_out_preno' => 'required|valid_date[Y-m-d]',
  'mod_out_conto' => 'permit_empty|valid_date[Y-m-d]',
  'mod_preno_id' => 'permit_empty|integer',
  'mod_camera_id' => 'permit_empty|integer',
  'mod_numero_camera' => 'permit_empty|integer',
  'mod_trattamento_sog' => 'permit_empty|max_length[100]',
  'mod_tipo_camera' => 'permit_empty|max_length[100]',
  'mod_prezzo' => 'permit_empty|max_length[100]',
  'mod_nome_cliente' => 'permit_empty|max_length[100]',
  'mod_cognome_cliente' => 'permit_empty|max_length[100]',
  'mod_preno_agenzia' => 'permit_empty|integer',
  'mod_mercato' => 'permit_empty|max_length[100]',
  'mod_conti_stato_camere' => 'permit_empty|max_length[100]',
  'mod_acconto' => 'permit_empty|max_length[100]',
  'modifica_conti_adebiti_utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'mod_conto_id' => 'permit_empty|integer|is_not_unique[conti.conto_id]',
  'mod_hotel_id' => 'permit_empty|integer',
  'mod_foglio_id' => 'permit_empty|integer',
  'mod_clienti_id' => 'permit_empty|integer',
  'mod_in_conto' => 'required|valid_date[Y-m-d]',
  'mod_out_preno' => 'required|valid_date[Y-m-d]',
  'mod_out_conto' => 'permit_empty|valid_date[Y-m-d]',
  'mod_preno_id' => 'permit_empty|integer',
  'mod_camera_id' => 'permit_empty|integer',
  'mod_numero_camera' => 'permit_empty|integer',
  'mod_trattamento_sog' => 'permit_empty|max_length[100]',
  'mod_tipo_camera' => 'permit_empty|max_length[100]',
  'mod_prezzo' => 'permit_empty|max_length[100]',
  'mod_nome_cliente' => 'permit_empty|max_length[100]',
  'mod_cognome_cliente' => 'permit_empty|max_length[100]',
  'mod_preno_agenzia' => 'permit_empty|integer',
  'mod_mercato' => 'permit_empty|max_length[100]',
  'mod_conti_stato_camere' => 'permit_empty|max_length[100]',
  'mod_acconto' => 'permit_empty|max_length[100]',
  'modifica_conti_adebiti_utente_id' => 'permit_empty|integer',
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
