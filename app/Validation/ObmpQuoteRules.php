<?php

declare(strict_types=1);

namespace App\Validation;

final class ObmpQuoteRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'permit_empty|integer',
  'quote_lg' => 'required|max_length[6]',
  'quote_dal' => 'required|valid_date[Y-m-d]',
  'quote_al' => 'required|valid_date[Y-m-d]',
  'quote_titolo' => 'required|max_length[8]',
  'quote_cognome' => 'permit_empty|max_length[225]',
  'quote_nome' => 'permit_empty|max_length[225]',
  'quote_email' => 'permit_empty|max_length[100]|valid_email',
  'trattamento_id' => 'permit_empty|max_length[10]',
  'trariffa_id' => 'permit_empty|integer',
  'cax_policy_id' => 'permit_empty|integer',
  'quote_tel_rich' => 'permit_empty|integer',
  'quote_cc_rich' => 'permit_empty|integer',
  'quote_del' => 'permit_empty|valid_date[Y-m-d]',
  'quote_data_time' => 'permit_empty|valid_date',
  'utente_id' => 'permit_empty|integer',
  'quote_stato' => 'required|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'permit_empty|integer',
  'quote_lg' => 'required|max_length[6]',
  'quote_dal' => 'required|valid_date[Y-m-d]',
  'quote_al' => 'required|valid_date[Y-m-d]',
  'quote_titolo' => 'required|max_length[8]',
  'quote_cognome' => 'permit_empty|max_length[225]',
  'quote_nome' => 'permit_empty|max_length[225]',
  'quote_email' => 'permit_empty|max_length[100]|valid_email',
  'trattamento_id' => 'permit_empty|max_length[10]',
  'trariffa_id' => 'permit_empty|integer',
  'cax_policy_id' => 'permit_empty|integer',
  'quote_tel_rich' => 'permit_empty|integer',
  'quote_cc_rich' => 'permit_empty|integer',
  'quote_del' => 'permit_empty|valid_date[Y-m-d]',
  'quote_data_time' => 'permit_empty|valid_date',
  'utente_id' => 'permit_empty|integer',
  'quote_stato' => 'required|integer',
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
