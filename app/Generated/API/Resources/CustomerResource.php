<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa customer secondo la configurazione del Builder. */
final class CustomerResource
{
    private const READABLE = array (
  0 => 'customer_id',
  1 => 'store_id',
  2 => 'first_name',
  3 => 'last_name',
  4 => 'email',
  5 => 'address_id',
  6 => 'active',
  7 => 'create_date',
  8 => 'last_update',
  9 => 'address_id__label',
  10 => 'store_id__label',
);
    private const WRITABLE = array (
  0 => 'store_id',
  1 => 'first_name',
  2 => 'last_name',
  3 => 'email',
  4 => 'address_id',
  5 => 'active',
  6 => 'create_date',
);
    private const FILTERABLE = array (
  0 => 'customer_id',
  1 => 'store_id',
  2 => 'last_name',
  3 => 'address_id',
);
    private const SORTABLE = array (
  0 => 'customer_id',
  1 => 'store_id',
  2 => 'last_name',
  3 => 'address_id',
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
