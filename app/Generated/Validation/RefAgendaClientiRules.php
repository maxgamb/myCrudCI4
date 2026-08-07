<?php

declare(strict_types=1);

namespace App\Validation;

final class RefAgendaClientiRules
{
    public static function createRules(): array
    {
        return array (
  'preno_id' => 'required|integer|is_not_unique[agenda.preno_id]',
  'clienti_id' => 'required|integer',
  'tipologia_id' => 'required|integer',
  'ref_a_c_datarecord' => 'permit_empty|valid_date',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'preno_id' => 'required|integer|is_not_unique[agenda.preno_id]',
  'clienti_id' => 'required|integer',
  'tipologia_id' => 'required|integer',
  'ref_a_c_datarecord' => 'permit_empty|valid_date',
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
