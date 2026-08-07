<?php

declare(strict_types=1);

namespace App\Validation;

final class ListinoPeriodiObmpRules
{
    public static function createRules(): array
    {
        return array (
  'listino_nome_id' => 'permit_empty|integer|is_not_unique[listino_nome_obmp.listino_nome_id]',
  'listino_periodi_flex' => 'permit_empty|integer',
  'listino_dal' => 'required|valid_date[Y-m-d]',
  'listino_al' => 'required|valid_date[Y-m-d]',
  'hotel_id' => 'permit_empty|integer',
  'listino_periodi' => 'permit_empty|valid_date',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'listino_nome_id' => 'permit_empty|integer|is_not_unique[listino_nome_obmp.listino_nome_id]',
  'listino_periodi_flex' => 'permit_empty|integer',
  'listino_dal' => 'required|valid_date[Y-m-d]',
  'listino_al' => 'required|valid_date[Y-m-d]',
  'hotel_id' => 'permit_empty|integer',
  'listino_periodi' => 'permit_empty|valid_date',
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
