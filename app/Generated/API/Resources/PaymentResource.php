<?php

declare(strict_types=1);

namespace App\API\Resources;

/**
 * Output-only serializer for `payment`.
 *
 * It performs no queries, request parsing, validation, or persistence.
 */
final class PaymentResource
{
    private const READABLE = array (
  0 => 'payment_id',
  1 => 'customer_id',
  2 => 'staff_id',
  3 => 'rental_id',
  4 => 'amount',
  5 => 'payment_date',
  6 => 'last_update',
  7 => 'customer_id__label',
  8 => 'rental_id__label',
  9 => 'staff_id__label',
);

    public static function make(object|array $record): array
    {
        if (is_array($record)) {
            $source = $record;
        } elseif (method_exists($record, 'toRawArray')) {
            $source = $record->toRawArray();
        } elseif (method_exists($record, 'toArray')) {
            $source = $record->toArray();
        } else {
            $source = get_object_vars($record);
        }

        return array_intersect_key($source, array_flip(self::READABLE));
    }

    public static function collection(array $records): array
    {
        return array_map(static fn (object|array $record): array => self::make($record), $records);
    }
}
