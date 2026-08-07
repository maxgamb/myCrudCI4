<?php

declare(strict_types=1);

namespace App\Validation;

final class ObmpRefEventRules
{
    public static function createRules(): array
    {
        return array (
  'ref_site_id' => 'permit_empty|integer|is_not_unique[obmp_ref_site.ref_site_id]',
  'hotel_id' => 'permit_empty|integer',
  'listino_nome_id' => 'permit_empty|integer|is_not_unique[listino_nome_obmp.listino_nome_id]',
  'agenzia_id' => 'permit_empty|integer|is_not_unique[agenzie.agenzia_id]',
  'ref_event_nome' => 'permit_empty|max_length[250]',
  'event_dal' => 'required|valid_date[Y-m-d]',
  'event_al' => 'required|valid_date[Y-m-d]',
  'ref_event_note' => 'permit_empty|max_length[250]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'ref_site_id' => 'permit_empty|integer|is_not_unique[obmp_ref_site.ref_site_id]',
  'hotel_id' => 'permit_empty|integer',
  'listino_nome_id' => 'permit_empty|integer|is_not_unique[listino_nome_obmp.listino_nome_id]',
  'agenzia_id' => 'permit_empty|integer|is_not_unique[agenzie.agenzia_id]',
  'ref_event_nome' => 'permit_empty|max_length[250]',
  'event_dal' => 'required|valid_date[Y-m-d]',
  'event_al' => 'required|valid_date[Y-m-d]',
  'ref_event_note' => 'permit_empty|max_length[250]',
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
