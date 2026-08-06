<?php

declare(strict_types=1);

namespace App\Validation;

final class AgenzieRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'required|integer',
  'agenzia_tipologia' => 'permit_empty|max_length[50]',
  'agenzia_nome' => 'required|max_length[100]',
  'agenzia_via' => 'permit_empty|max_length[100]',
  'agenzia_citta' => 'permit_empty|max_length[100]',
  'agenzia_state' => 'permit_empty|max_length[100]',
  'agenzia_country' => 'permit_empty|max_length[100]',
  'agenzia_cap' => 'permit_empty|max_length[100]',
  'agenzia_tel' => 'permit_empty|max_length[100]',
  'agenzia_fax' => 'permit_empty|max_length[100]',
  'agenzia_email' => 'permit_empty|max_length[100]|valid_email',
  'agenzia_web' => 'permit_empty|max_length[200]',
  'agenzia_par_iva' => 'permit_empty|max_length[100]',
  'agenzia_par_cf' => 'permit_empty|max_length[200]',
  'agenzia_pec' => 'permit_empty|max_length[200]',
  'agenzia_sid' => 'permit_empty|max_length[200]',
  'agenzia_referente' => 'permit_empty|max_length[100]',
  'agenzia_banca_nome' => 'permit_empty|max_length[50]',
  'agenzia_banca_iban' => 'permit_empty|max_length[50]',
  'agenzia_banca_swift' => 'permit_empty|max_length[50]',
  'agenzia_banca_iata' => 'permit_empty|max_length[50]',
  'agenzia_cc_tipo' => 'permit_empty|max_length[50]',
  'agenzia_cc_nome' => 'permit_empty|max_length[50]',
  'agenzia_cc_numero' => 'permit_empty|max_length[50]',
  'agenzia_cc_scadenza' => 'permit_empty|max_length[50]',
  'agenzia_cc_cod_sicurezza' => 'permit_empty|max_length[50]',
  'agenzia_login' => 'permit_empty|max_length[200]',
  'agenzia_password' => 'permit_empty|max_length[200]',
  'agenzia_ab_web' => 'permit_empty|exact_length[2]',
  'agenzia_ab_affiliati' => 'permit_empty|exact_length[2]',
  'agenzia_ad_vis' => 'permit_empty|exact_length[2]',
  'agenzia_ab_sospeso' => 'permit_empty|exact_length[2]',
  'agenzia_data_record' => 'required|valid_date',
  'agenzie_utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'required|integer',
  'agenzia_tipologia' => 'permit_empty|max_length[50]',
  'agenzia_nome' => 'required|max_length[100]',
  'agenzia_via' => 'permit_empty|max_length[100]',
  'agenzia_citta' => 'permit_empty|max_length[100]',
  'agenzia_state' => 'permit_empty|max_length[100]',
  'agenzia_country' => 'permit_empty|max_length[100]',
  'agenzia_cap' => 'permit_empty|max_length[100]',
  'agenzia_tel' => 'permit_empty|max_length[100]',
  'agenzia_fax' => 'permit_empty|max_length[100]',
  'agenzia_email' => 'permit_empty|max_length[100]|valid_email',
  'agenzia_web' => 'permit_empty|max_length[200]',
  'agenzia_par_iva' => 'permit_empty|max_length[100]',
  'agenzia_par_cf' => 'permit_empty|max_length[200]',
  'agenzia_pec' => 'permit_empty|max_length[200]',
  'agenzia_sid' => 'permit_empty|max_length[200]',
  'agenzia_referente' => 'permit_empty|max_length[100]',
  'agenzia_banca_nome' => 'permit_empty|max_length[50]',
  'agenzia_banca_iban' => 'permit_empty|max_length[50]',
  'agenzia_banca_swift' => 'permit_empty|max_length[50]',
  'agenzia_banca_iata' => 'permit_empty|max_length[50]',
  'agenzia_cc_tipo' => 'permit_empty|max_length[50]',
  'agenzia_cc_nome' => 'permit_empty|max_length[50]',
  'agenzia_cc_numero' => 'permit_empty|max_length[50]',
  'agenzia_cc_scadenza' => 'permit_empty|max_length[50]',
  'agenzia_cc_cod_sicurezza' => 'permit_empty|max_length[50]',
  'agenzia_login' => 'permit_empty|max_length[200]',
  'agenzia_password' => 'permit_empty|max_length[200]',
  'agenzia_ab_web' => 'permit_empty|exact_length[2]',
  'agenzia_ab_affiliati' => 'permit_empty|exact_length[2]',
  'agenzia_ad_vis' => 'permit_empty|exact_length[2]',
  'agenzia_ab_sospeso' => 'permit_empty|exact_length[2]',
  'agenzia_data_record' => 'required|valid_date',
  'agenzie_utente_id' => 'permit_empty|integer',
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
