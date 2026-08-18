<?php

declare(strict_types=1);

namespace App\API\Resources;

/**
 * Output-only serializer for `customer_list`.
 *
 * It performs no queries, request parsing, validation, or persistence.
 */
final class CustomerListResource
{
    private const READABLE = array (
  0 => 'ID',
  1 => 'name',
  2 => 'address',
  3 => 'zip code',
  4 => 'phone',
  5 => 'city',
  6 => 'country',
  7 => 'notes',
  8 => 'SID',
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
