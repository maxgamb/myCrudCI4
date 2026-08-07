<?php

declare(strict_types=1);

namespace App\Validation;

final class ShiftsRules
{
    public static function createRules(): array
    {
        return array (
  'staff_id' => 'required|integer|is_not_unique[staff.staff_id]',
  'hotel_id' => 'required|integer',
  'shift_date' => 'required|valid_date[Y-m-d]',
  'position' => 'required|integer',
  'shift_time' => 'required',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'staff_id' => 'required|integer|is_not_unique[staff.staff_id]',
  'hotel_id' => 'required|integer',
  'shift_date' => 'required|valid_date[Y-m-d]',
  'position' => 'required|integer',
  'shift_time' => 'required',
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
