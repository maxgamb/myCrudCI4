<?php

declare(strict_types=1);

namespace App\Validation;

final class ChecklistPrenoRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'required|integer',
  'preno_id' => 'required|integer',
  'preno_dal' => 'required|valid_date[Y-m-d]',
  'email' => 'required|max_length[200]|valid_email',
  'email_pms' => 'required|integer|valid_email',
  'lista' => 'required|integer',
  'lista_pms' => 'required|integer',
  'pagamento' => 'required|integer',
  'tassa' => 'required|integer',
  'proforma' => 'required|integer',
  'proforma_pms' => 'required|integer',
  'bonifico' => 'required|integer',
  'importo' => 'required|decimal',
  'note' => 'required',
  'data_check' => 'required|valid_date[Y-m-d]',
  'utente_id' => 'required|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'required|integer',
  'preno_id' => 'required|integer',
  'preno_dal' => 'required|valid_date[Y-m-d]',
  'email' => 'required|max_length[200]|valid_email',
  'email_pms' => 'required|integer|valid_email',
  'lista' => 'required|integer',
  'lista_pms' => 'required|integer',
  'pagamento' => 'required|integer',
  'tassa' => 'required|integer',
  'proforma' => 'required|integer',
  'proforma_pms' => 'required|integer',
  'bonifico' => 'required|integer',
  'importo' => 'required|decimal',
  'note' => 'required',
  'data_check' => 'required|valid_date[Y-m-d]',
  'utente_id' => 'required|integer',
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
