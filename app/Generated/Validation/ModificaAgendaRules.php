<?php

declare(strict_types=1);

namespace App\Validation;

final class ModificaAgendaRules
{
    public static function createRules(): array
    {
        return array (
  'mod_preno_id' => 'permit_empty|integer',
  'mod_agenda_valori' => 'required',
  'mod_preno_data_records' => 'permit_empty|valid_date',
  'modifica_agenda_adebiti_utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'mod_preno_id' => 'permit_empty|integer',
  'mod_agenda_valori' => 'required',
  'mod_preno_data_records' => 'permit_empty|valid_date',
  'modifica_agenda_adebiti_utente_id' => 'permit_empty|integer',
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
