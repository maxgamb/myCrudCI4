<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa guasti secondo la configurazione del Builder. */
final class GuastiResource
{
    private const READABLE = array (
  0 => 'guasto_id',
  1 => 'hotel_id',
  2 => 'camera_id',
  3 => 'guasto_priorita',
  4 => 'guasto_area',
  5 => 'guasto_piano',
  6 => 'guasto_note',
  7 => 'guasto_stato',
  8 => 'guasto_data',
  9 => 'guasto_utente_id',
  10 => 'camere__camera_id__label',
  11 => 'hotels__hotel_id__label',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'camera_id',
  2 => 'guasto_priorita',
  3 => 'guasto_area',
  4 => 'guasto_piano',
  5 => 'guasto_note',
  6 => 'guasto_stato',
  7 => 'guasto_data',
  8 => 'guasto_utente_id',
);
    private const FILTERABLE = array (
  0 => 'guasto_id',
  1 => 'hotel_id',
  2 => 'camera_id',
  3 => 'guasto_stato',
  4 => 'guasto_data',
);
    private const SORTABLE = array (
  0 => 'guasto_id',
  1 => 'hotel_id',
  2 => 'camera_id',
  3 => 'guasto_stato',
  4 => 'guasto_data',
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
