<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa win_booking secondo la configurazione del Builder. */
final class WinBookingResource
{
    private const READABLE = array (
  0 => 'win_id',
  1 => 'hotel_id',
  2 => 'win_dal',
  3 => 'win_al',
  4 => 'mese',
  5 => 'win_hotel',
  6 => 'win_comp',
  7 => 'win_hotel_cum',
  8 => 'win_comp_cum',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'win_dal',
  2 => 'win_al',
  3 => 'mese',
  4 => 'win_hotel',
  5 => 'win_comp',
  6 => 'win_hotel_cum',
  7 => 'win_comp_cum',
);
    private const FILTERABLE = array (
  0 => 'win_id',
);
    private const SORTABLE = array (
  0 => 'win_id',
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
