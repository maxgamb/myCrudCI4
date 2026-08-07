<?php

declare(strict_types=1);

namespace App\Validation;

final class LogRichiesteRules
{
    public static function createRules(): array
    {
        return array (
  'log_ric_hotel_id' => 'required|integer',
  'log_ric_dal' => 'required|valid_date[Y-m-d]',
  'log_ric_al' => 'required|valid_date[Y-m-d]',
  'log_ric_data' => 'required|valid_date[Y-m-d]',
  'log_ric_notti' => 'required|integer',
  'log_ric_wind' => 'required|integer',
  'log_ric_utente_id' => 'required|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'log_ric_hotel_id' => 'required|integer',
  'log_ric_dal' => 'required|valid_date[Y-m-d]',
  'log_ric_al' => 'required|valid_date[Y-m-d]',
  'log_ric_data' => 'required|valid_date[Y-m-d]',
  'log_ric_notti' => 'required|integer',
  'log_ric_wind' => 'required|integer',
  'log_ric_utente_id' => 'required|integer',
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
