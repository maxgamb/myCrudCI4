<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa shifts secondo la configurazione del Builder. */
final class ShiftsResource
{
    private const READABLE = array (
  0 => 'id',
  1 => 'staff_id',
  2 => 'hotel_id',
  3 => 'shift_date',
  4 => 'position',
  5 => 'shift_time',
  6 => 'staff_nome',
);
    private const WRITABLE = array (
  0 => 'staff_id',
  1 => 'hotel_id',
  2 => 'shift_date',
  3 => 'position',
  4 => 'shift_time',
);
    private const FILTERABLE = array (
  0 => 'id',
  1 => 'staff_id',
  2 => 'hotel_id',
  3 => 'shift_date',
);
    private const SORTABLE = array (
  0 => 'id',
  1 => 'staff_id',
  2 => 'hotel_id',
  3 => 'shift_date',
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
