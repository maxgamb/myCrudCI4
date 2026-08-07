<?php

declare(strict_types=1);

namespace App\Validation;

final class ContiTrasferisciRules
{
    public static function createRules(): array
    {
        return array (
  'conto_id_ex' => 'permit_empty|integer',
  'conto_id_new' => 'permit_empty|integer',
  'hotel_id' => 'permit_empty|integer',
  'adebito_id' => 'permit_empty|integer|is_not_unique[adebiti.adebito_id]',
  'conti_tra_data' => 'permit_empty|valid_date',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'conto_id_ex' => 'permit_empty|integer',
  'conto_id_new' => 'permit_empty|integer',
  'hotel_id' => 'permit_empty|integer',
  'adebito_id' => 'permit_empty|integer|is_not_unique[adebiti.adebito_id]',
  'conti_tra_data' => 'permit_empty|valid_date',
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
