<?php

declare(strict_types=1);

namespace App\Validation;

final class CostiAreaRules
{
    public static function createRules(): array
    {
        return array (
  'costi_area_nome' => 'permit_empty|max_length[225]',
  'costi_area' => 'permit_empty|max_length[45]',
  'utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'costi_area_nome' => 'permit_empty|max_length[225]',
  'costi_area' => 'permit_empty|max_length[45]',
  'utente_id' => 'permit_empty|integer',
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
