<?php

declare(strict_types=1);

namespace App\Validation;

final class WinBookingRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'required|integer',
  'win_dal' => 'required|integer',
  'win_al' => 'required|integer',
  'mese' => 'required|integer',
  'win_hotel' => 'required|integer',
  'win_comp' => 'required|integer',
  'win_hotel_cum' => 'required|integer',
  'win_comp_cum' => 'required|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'required|integer',
  'win_dal' => 'required|integer',
  'win_al' => 'required|integer',
  'mese' => 'required|integer',
  'win_hotel' => 'required|integer',
  'win_comp' => 'required|integer',
  'win_hotel_cum' => 'required|integer',
  'win_comp_cum' => 'required|integer',
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
