<?php

declare(strict_types=1);

namespace App\Validation;

final class RefObmpBookingRules
{
    public static function createRules(): array
    {
        return array (
  'ref_obm_data' => 'permit_empty|valid_date',
  'preno_id' => 'permit_empty|integer|is_not_unique[agenda.preno_id]',
  'obm_cliente_id' => 'permit_empty|integer|is_not_unique[obmp_clienti.obm_cliente_id]',
  'hotel_id' => 'permit_empty|integer',
  'ref_site' => 'permit_empty|integer|is_not_unique[obmp_ref_site.ref_site_id]',
  'ref_agency' => 'permit_empty|integer',
  'ref_event' => 'permit_empty|integer',
  'ref_session' => 'permit_empty|max_length[200]',
  'ref_cookie' => 'permit_empty|max_length[200]',
  'room_obmp_string' => 'permit_empty|max_length[255]',
  'quote_id' => 'permit_empty|integer|is_not_unique[obmp_quote.quote_id]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'ref_obm_data' => 'permit_empty|valid_date',
  'preno_id' => 'permit_empty|integer|is_not_unique[agenda.preno_id]',
  'obm_cliente_id' => 'permit_empty|integer|is_not_unique[obmp_clienti.obm_cliente_id]',
  'hotel_id' => 'permit_empty|integer',
  'ref_site' => 'permit_empty|integer|is_not_unique[obmp_ref_site.ref_site_id]',
  'ref_agency' => 'permit_empty|integer',
  'ref_event' => 'permit_empty|integer',
  'ref_session' => 'permit_empty|max_length[200]',
  'ref_cookie' => 'permit_empty|max_length[200]',
  'room_obmp_string' => 'permit_empty|max_length[255]',
  'quote_id' => 'permit_empty|integer|is_not_unique[obmp_quote.quote_id]',
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
