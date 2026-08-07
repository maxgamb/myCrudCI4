<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa ef_price_table secondo la configurazione del Builder. */
final class EfPriceTableResource
{
    private const READABLE = array (
  0 => 'price_ef_is',
  1 => 'hotel_id',
  2 => 'from',
  3 => 'to',
  4 => 'single',
  5 => 'single_plus',
  6 => 'tw_db',
  7 => 'student',
  8 => 'fam_tr',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'from',
  2 => 'to',
  3 => 'single',
  4 => 'single_plus',
  5 => 'tw_db',
  6 => 'student',
  7 => 'fam_tr',
);
    private const FILTERABLE = array (
  0 => 'price_ef_is',
  1 => 'hotel_id',
  2 => 'from',
  3 => 'to',
);
    private const SORTABLE = array (
  0 => 'price_ef_is',
  1 => 'hotel_id',
  2 => 'from',
  3 => 'to',
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
