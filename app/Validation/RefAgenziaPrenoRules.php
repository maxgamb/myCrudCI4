<?php

declare(strict_types=1);

namespace App\Validation;

final class RefAgenziaPrenoRules
{
    public static function createRules(): array
    {
        return array (
  'agenzia_id' => 'required|integer|is_not_unique[agenzie.agenzia_id]',
  'preno_id' => 'required|integer|is_not_unique[agenda.preno_id]',
  'ref_a_p_datarecord' => 'permit_empty|valid_date',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'agenzia_id' => 'required|integer|is_not_unique[agenzie.agenzia_id]',
  'preno_id' => 'required|integer|is_not_unique[agenda.preno_id]',
  'ref_a_p_datarecord' => 'permit_empty|valid_date',
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
