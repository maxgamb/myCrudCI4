<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa manutenzioni secondo la configurazione del Builder. */
final class ManutenzioniResource
{
    private const READABLE = array (
  0 => 'manutenzione_id',
  1 => 'hotel_id',
  2 => 'manut_priorita',
  3 => 'manut_area_guasto',
  4 => 'manut_piano',
  5 => 'manut_camera',
  6 => 'manut_descrizione',
  7 => 'manut_data_segnalazione',
  8 => 'manut_stato',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'manut_priorita',
  2 => 'manut_area_guasto',
  3 => 'manut_piano',
  4 => 'manut_camera',
  5 => 'manut_descrizione',
  6 => 'manut_data_segnalazione',
  7 => 'manut_stato',
);
    private const FILTERABLE = array (
  0 => 'manutenzione_id',
);
    private const SORTABLE = array (
  0 => 'manutenzione_id',
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
