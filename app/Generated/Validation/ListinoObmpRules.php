<?php

declare(strict_types=1);

namespace App\Validation;

final class ListinoObmpRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'permit_empty|integer',
  'listino_nome_id' => 'permit_empty|integer|is_not_unique[listino_nome_obmp.listino_nome_id]',
  'tipologia_id' => 'permit_empty|integer|is_not_unique[obmp_cm_rooms.obmp_cm_rooms_id]',
  'listino_prezzo' => 'permit_empty|decimal',
  'ref_site' => 'permit_empty|integer',
  'ref_agency' => 'permit_empty|integer',
  'ref_event' => 'permit_empty|integer',
  'ref_session' => 'permit_empty|integer',
  'ref_cookie' => 'permit_empty|integer',
  'listino_obmp_datarecord' => 'permit_empty|valid_date',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'permit_empty|integer',
  'listino_nome_id' => 'permit_empty|integer|is_not_unique[listino_nome_obmp.listino_nome_id]',
  'tipologia_id' => 'permit_empty|integer|is_not_unique[obmp_cm_rooms.obmp_cm_rooms_id]',
  'listino_prezzo' => 'permit_empty|decimal',
  'ref_site' => 'permit_empty|integer',
  'ref_agency' => 'permit_empty|integer',
  'ref_event' => 'permit_empty|integer',
  'ref_session' => 'permit_empty|integer',
  'ref_cookie' => 'permit_empty|integer',
  'listino_obmp_datarecord' => 'permit_empty|valid_date',
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
