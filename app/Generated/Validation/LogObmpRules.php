<?php

declare(strict_types=1);

namespace App\Validation;

final class LogObmpRules
{
    public static function createRules(): array
    {
        return array (
  'preno_dal' => 'permit_empty|valid_date[Y-m-d]',
  'preno_al' => 'permit_empty|valid_date[Y-m-d]',
  'Q1' => 'permit_empty|integer',
  'T1' => 'permit_empty|integer',
  'hotel_id' => 'permit_empty|integer',
  'ref_site' => 'permit_empty|max_length[200]',
  'ref_agency' => 'permit_empty|max_length[200]',
  'ref_event' => 'permit_empty|max_length[200]',
  'ref_session' => 'permit_empty|max_length[200]',
  'ref_cookie' => 'permit_empty|max_length[200]',
  'mygooglekeyword' => 'permit_empty|max_length[225]',
  'log_obmp_daterecord' => 'permit_empty|valid_date',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'preno_dal' => 'permit_empty|valid_date[Y-m-d]',
  'preno_al' => 'permit_empty|valid_date[Y-m-d]',
  'Q1' => 'permit_empty|integer',
  'T1' => 'permit_empty|integer',
  'hotel_id' => 'permit_empty|integer',
  'ref_site' => 'permit_empty|max_length[200]',
  'ref_agency' => 'permit_empty|max_length[200]',
  'ref_event' => 'permit_empty|max_length[200]',
  'ref_session' => 'permit_empty|max_length[200]',
  'ref_cookie' => 'permit_empty|max_length[200]',
  'mygooglekeyword' => 'permit_empty|max_length[225]',
  'log_obmp_daterecord' => 'permit_empty|valid_date',
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
