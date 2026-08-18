<?php

declare(strict_types=1);

namespace App\API\Resources;

/**
 * Output-only serializer for `address`.
 *
 * It performs no queries, request parsing, validation, or persistence.
 */
final class AddressResource
{
    private const READABLE = array (
  0 => 'address_id',
  1 => 'address',
  2 => 'address2',
  3 => 'district',
  4 => 'city_id',
  5 => 'postal_code',
  6 => 'phone',
  7 => 'last_update',
  8 => 'city_id__label',
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
