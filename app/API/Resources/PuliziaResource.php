<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa pulizia secondo la configurazione del Builder. */
final class PuliziaResource
{
    private const READABLE = array (
  0 => 'pulizia_id',
  1 => 'hotel_id',
  2 => 'conto_id',
  3 => 'camera_id',
  4 => 'cambio_biancheria',
  5 => 'pulizia_stato',
  6 => 'pulizia_data',
  7 => 'pulizia_note',
  8 => 'utente_id',
  9 => 'conti__conto_id__label',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'conto_id',
  2 => 'camera_id',
  3 => 'cambio_biancheria',
  4 => 'pulizia_stato',
  5 => 'pulizia_data',
  6 => 'pulizia_note',
  7 => 'utente_id',
);
    private const FILTERABLE = array (
  0 => 'pulizia_id',
  1 => 'hotel_id',
  2 => 'conto_id',
  3 => 'camera_id',
  4 => 'pulizia_data',
);
    private const SORTABLE = array (
  0 => 'pulizia_id',
  1 => 'hotel_id',
  2 => 'conto_id',
  3 => 'camera_id',
  4 => 'pulizia_data',
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
