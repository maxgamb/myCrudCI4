<?php

declare(strict_types=1);

namespace App\Validation;

final class RegistroPsRules
{
    public static function createRules(): array
    {
        return array (
  'registro_ps_hotel_id' => 'permit_empty|integer',
  'registro_ps_valore' => 'permit_empty|integer',
  'registro_ps_utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'registro_ps_hotel_id' => 'permit_empty|integer',
  'registro_ps_valore' => 'permit_empty|integer',
  'registro_ps_utente_id' => 'permit_empty|integer',
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
