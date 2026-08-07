<?php

declare(strict_types=1);

namespace App\Validation;

final class ObmpRatesRules
{
    public static function createRules(): array
    {
        return array (
  'obmp_cm_rooms_id' => 'required|integer|is_not_unique[obmp_cm_rooms.obmp_cm_rooms_id]',
  'obmp_restriction_id' => 'permit_empty|integer|is_not_unique[obmp_restrictions.obmp_restriction_id]',
  'hotel_id' => 'permit_empty|integer',
  'obmp_board_cod' => 'permit_empty|max_length[6]|is_not_unique[obmp_board.obmp_board_cod]',
  'obmp_cancellation_cod' => 'permit_empty|max_length[6]|is_not_unique[obmp_cancellations.obmp_cancellation_cod]',
  'obmp_payment_cod' => 'permit_empty|max_length[6]|is_not_unique[obmp_payments.obmp_payment_cod]',
  'rate_sum' => 'permit_empty|decimal',
  'rate_mol' => 'permit_empty|decimal',
  'rate_stato' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'obmp_cm_rooms_id' => 'required|integer|is_not_unique[obmp_cm_rooms.obmp_cm_rooms_id]',
  'obmp_restriction_id' => 'permit_empty|integer|is_not_unique[obmp_restrictions.obmp_restriction_id]',
  'hotel_id' => 'permit_empty|integer',
  'obmp_board_cod' => 'permit_empty|max_length[6]|is_not_unique[obmp_board.obmp_board_cod]',
  'obmp_cancellation_cod' => 'permit_empty|max_length[6]|is_not_unique[obmp_cancellations.obmp_cancellation_cod]',
  'obmp_payment_cod' => 'permit_empty|max_length[6]|is_not_unique[obmp_payments.obmp_payment_cod]',
  'rate_sum' => 'permit_empty|decimal',
  'rate_mol' => 'permit_empty|decimal',
  'rate_stato' => 'permit_empty|integer',
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
