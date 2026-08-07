<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa images secondo la configurazione del Builder. */
final class ImagesResource
{
    private const READABLE = array (
  0 => 'images_id',
  1 => 'hotel_id',
  2 => 'camera_id',
  3 => 'obmp_cm_rooms_id',
  4 => 'tipologia_id',
  5 => 'img_small',
  6 => 'img_medium',
  7 => 'img_large',
  8 => 'titolo',
  9 => 'utente_id',
  10 => 'obmp_cm_rooms_obmp_cm_rooms_room_note',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'camera_id',
  2 => 'obmp_cm_rooms_id',
  3 => 'tipologia_id',
  4 => 'img_small',
  5 => 'img_medium',
  6 => 'img_large',
  7 => 'titolo',
  8 => 'utente_id',
);
    private const FILTERABLE = array (
  0 => 'images_id',
  1 => 'hotel_id',
  2 => 'obmp_cm_rooms_id',
);
    private const SORTABLE = array (
  0 => 'images_id',
  1 => 'hotel_id',
  2 => 'obmp_cm_rooms_id',
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
