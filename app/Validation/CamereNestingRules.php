<?php

declare(strict_types=1);

namespace App\Validation;

final class CamereNestingRules
{
    public static function createRules(): array
    {
        return array (
  'camara_id' => 'required|integer',
  'tipologia_id' => 'required|integer',
  'voto' => 'required|integer',
  'nesting_utente_id' => 'required|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'camara_id' => 'required|integer',
  'tipologia_id' => 'required|integer',
  'voto' => 'required|integer',
  'nesting_utente_id' => 'required|integer',
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
