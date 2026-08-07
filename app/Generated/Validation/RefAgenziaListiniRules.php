<?php

declare(strict_types=1);

namespace App\Validation;

final class RefAgenziaListiniRules
{
    public static function createRules(): array
    {
        return array (
  'agenzia_listini_id' => 'permit_empty|integer|is_not_unique[agenzia_listini.agenzia_listini_id]',
  'agenzia_id' => 'permit_empty|integer|is_not_unique[agenzie.agenzia_id]',
  'hotel_id' => 'permit_empty|integer',
  'agenzia_limite_vendita' => 'permit_empty|integer',
  'agenzia_ab_limite_vendita' => 'permit_empty|integer',
  'agenzia_max_vendita' => 'permit_empty|integer',
  'agenzia_ab_max_vendita' => 'permit_empty|integer',
  'ref_agenzia_datarecord' => 'permit_empty|valid_date',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'agenzia_listini_id' => 'permit_empty|integer|is_not_unique[agenzia_listini.agenzia_listini_id]',
  'agenzia_id' => 'permit_empty|integer|is_not_unique[agenzie.agenzia_id]',
  'hotel_id' => 'permit_empty|integer',
  'agenzia_limite_vendita' => 'permit_empty|integer',
  'agenzia_ab_limite_vendita' => 'permit_empty|integer',
  'agenzia_max_vendita' => 'permit_empty|integer',
  'agenzia_ab_max_vendita' => 'permit_empty|integer',
  'ref_agenzia_datarecord' => 'permit_empty|valid_date',
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
