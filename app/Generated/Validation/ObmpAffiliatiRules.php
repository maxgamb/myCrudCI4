<?php

declare(strict_types=1);

namespace App\Validation;

final class ObmpAffiliatiRules
{
    public static function createRules(): array
    {
        return array (
  'obmp_aff_societa' => 'permit_empty|max_length[250]',
  'obmp_aff_sito' => 'permit_empty|max_length[250]',
  'obmp_aff_email' => 'permit_empty|max_length[100]|valid_email',
  'obmp_aff_pasword' => 'permit_empty|max_length[20]',
  'obmp_aff_cookies' => 'permit_empty|integer',
  'obmp_aff_commisione' => 'permit_empty|decimal',
  'obmp_aff_mark_up' => 'permit_empty|decimal',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'obmp_aff_societa' => 'permit_empty|max_length[250]',
  'obmp_aff_sito' => 'permit_empty|max_length[250]',
  'obmp_aff_email' => 'permit_empty|max_length[100]|valid_email',
  'obmp_aff_pasword' => 'permit_empty|max_length[20]',
  'obmp_aff_cookies' => 'permit_empty|integer',
  'obmp_aff_commisione' => 'permit_empty|decimal',
  'obmp_aff_mark_up' => 'permit_empty|decimal',
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
