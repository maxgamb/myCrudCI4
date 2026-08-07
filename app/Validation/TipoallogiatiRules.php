<?php

declare(strict_types=1);

namespace App\Validation;

final class TipoallogiatiRules
{
    public static function createRules(): array
    {
        return array (
  'Tip_all_Cod' => 'permit_empty|max_length[30]',
  'Tip_all_Descrizione' => 'permit_empty|max_length[250]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'Tip_all_Cod' => 'permit_empty|max_length[30]',
  'Tip_all_Descrizione' => 'permit_empty|max_length[250]',
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
