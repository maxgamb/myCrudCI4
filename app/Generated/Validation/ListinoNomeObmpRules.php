<?php

declare(strict_types=1);

namespace App\Validation;

final class ListinoNomeObmpRules
{
    public static function createRules(): array
    {
        return array (
  'listino_nome' => 'permit_empty|max_length[250]',
  'hotel_id' => 'permit_empty|integer',
  'yield' => 'required|integer',
  'listino_nome_datarecord' => 'permit_empty|valid_date',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'listino_nome' => 'permit_empty|max_length[250]',
  'hotel_id' => 'permit_empty|integer',
  'yield' => 'required|integer',
  'listino_nome_datarecord' => 'permit_empty|valid_date',
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
