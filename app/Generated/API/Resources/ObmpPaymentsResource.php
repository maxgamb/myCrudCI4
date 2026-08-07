<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa obmp_payments secondo la configurazione del Builder. */
final class ObmpPaymentsResource
{
    private const READABLE = array (
  0 => 'obmp_payment_id',
  1 => 'obmp_payment_cod',
  2 => 'obmp_payment_title',
  3 => 'obmp_payment',
  4 => 'obmp_payment_value',
  5 => 'payment_lg',
);
    private const WRITABLE = array (
  0 => 'obmp_payment_cod',
  1 => 'obmp_payment_title',
  2 => 'obmp_payment',
  3 => 'obmp_payment_value',
  4 => 'payment_lg',
);
    private const FILTERABLE = array (
  0 => 'obmp_payment_id',
  1 => 'obmp_payment_cod',
);
    private const SORTABLE = array (
  0 => 'obmp_payment_id',
  1 => 'obmp_payment_cod',
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
