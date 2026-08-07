<?php

declare(strict_types=1);

namespace App\Validation;

final class ObmpRefSiteRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'permit_empty|integer',
  'obmp_affiliati_id' => 'permit_empty|integer',
  'ref_site_nome' => 'permit_empty|max_length[200]',
  'ref_site_date_record' => 'permit_empty|valid_date',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'permit_empty|integer',
  'obmp_affiliati_id' => 'permit_empty|integer',
  'ref_site_nome' => 'permit_empty|max_length[200]',
  'ref_site_date_record' => 'permit_empty|valid_date',
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
