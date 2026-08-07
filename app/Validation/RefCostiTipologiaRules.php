<?php

declare(strict_types=1);

namespace App\Validation;

final class RefCostiTipologiaRules
{
    public static function createRules(): array
    {
        return array (
  'costi_var_id' => 'permit_empty|integer|is_not_unique[costi_var.costi_var_id]',
  'tipologia_id' => 'permit_empty|integer|is_not_unique[tipologia_camera.tipologia_id]',
  'hotel_id' => 'permit_empty|integer',
  'stay' => 'permit_empty|integer',
  'days' => 'required|integer',
  'check_out' => 'permit_empty|integer',
  'utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'costi_var_id' => 'permit_empty|integer|is_not_unique[costi_var.costi_var_id]',
  'tipologia_id' => 'permit_empty|integer|is_not_unique[tipologia_camera.tipologia_id]',
  'hotel_id' => 'permit_empty|integer',
  'stay' => 'permit_empty|integer',
  'days' => 'required|integer',
  'check_out' => 'permit_empty|integer',
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
