<?php

declare(strict_types=1);

namespace App\Validation;

final class EfPriceTableRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'permit_empty|integer',
  'from' => 'permit_empty|valid_date[Y-m-d]',
  'to' => 'permit_empty|valid_date[Y-m-d]',
  'single' => 'permit_empty|integer',
  'single_plus' => 'permit_empty|integer',
  'tw_db' => 'permit_empty|integer',
  'student' => 'permit_empty|integer',
  'fam_tr' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'permit_empty|integer',
  'from' => 'permit_empty|valid_date[Y-m-d]',
  'to' => 'permit_empty|valid_date[Y-m-d]',
  'single' => 'permit_empty|integer',
  'single_plus' => 'permit_empty|integer',
  'tw_db' => 'permit_empty|integer',
  'student' => 'permit_empty|integer',
  'fam_tr' => 'permit_empty|integer',
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
