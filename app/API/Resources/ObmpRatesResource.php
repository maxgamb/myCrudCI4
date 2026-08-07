<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa obmp_rates secondo la configurazione del Builder. */
final class ObmpRatesResource
{
    private const READABLE = array (
  0 => 'obmp_rate_id',
  1 => 'obmp_cm_rooms_id',
  2 => 'obmp_restriction_id',
  3 => 'hotel_id',
  4 => 'obmp_board_cod',
  5 => 'obmp_cancellation_cod',
  6 => 'obmp_payment_cod',
  7 => 'rate_sum',
  8 => 'rate_mol',
  9 => 'rate_stato',
  10 => 'obmp_board_obmp_board_title',
  11 => 'obmp_cancellations_obmp_cancellation_title',
  12 => 'obmp_cm_rooms_obmp_cm_rooms_room_note',
  13 => 'obmp_payments_obmp_payment_title',
  14 => 'obmp_restrictions_hotel_id',
);
    private const WRITABLE = array (
  0 => 'obmp_cm_rooms_id',
  1 => 'obmp_restriction_id',
  2 => 'hotel_id',
  3 => 'obmp_board_cod',
  4 => 'obmp_cancellation_cod',
  5 => 'obmp_payment_cod',
  6 => 'rate_sum',
  7 => 'rate_mol',
  8 => 'rate_stato',
);
    private const FILTERABLE = array (
  0 => 'obmp_rate_id',
  1 => 'obmp_cm_rooms_id',
  2 => 'obmp_restriction_id',
  3 => 'obmp_board_cod',
  4 => 'obmp_cancellation_cod',
  5 => 'obmp_payment_cod',
);
    private const SORTABLE = array (
  0 => 'obmp_rate_id',
  1 => 'obmp_cm_rooms_id',
  2 => 'obmp_restriction_id',
  3 => 'obmp_board_cod',
  4 => 'obmp_cancellation_cod',
  5 => 'obmp_payment_cod',
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

    public static function writableData(array $data): array
    {
        return array_intersect_key($data, array_flip(self::WRITABLE));
    }

    public static function filterableFields(): array
    {
        return self::FILTERABLE;
    }

    public static function sortableFields(): array
    {
        return self::SORTABLE;
    }
}
