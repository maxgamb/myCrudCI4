<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa staff secondo la configurazione del Builder. */
final class StaffResource
{
    private const READABLE = array (
  0 => 'staff_id',
  1 => 'first_name',
  2 => 'last_name',
  3 => 'address_id',
  4 => 'email',
  5 => 'store_id',
  6 => 'active',
  7 => 'username',
  8 => 'password',
  9 => 'last_update',
  10 => 'address_id__label',
  11 => 'store_id__label',
);
    private const WRITABLE = array (
  0 => 'first_name',
  1 => 'last_name',
  2 => 'address_id',
  3 => 'picture',
  4 => 'email',
  5 => 'store_id',
  6 => 'active',
  7 => 'username',
  8 => 'password',
);
    private const FILTERABLE = array (
  0 => 'staff_id',
  1 => 'address_id',
  2 => 'store_id',
);
    private const SORTABLE = array (
  0 => 'staff_id',
  1 => 'address_id',
  2 => 'store_id',
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
