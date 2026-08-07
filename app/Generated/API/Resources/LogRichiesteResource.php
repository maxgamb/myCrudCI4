<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa log_richieste secondo la configurazione del Builder. */
final class LogRichiesteResource
{
    private const READABLE = array (
  0 => 'log_ric_id',
  1 => 'log_ric_hotel_id',
  2 => 'log_ric_dal',
  3 => 'log_ric_al',
  4 => 'log_ric_data',
  5 => 'log_ric_notti',
  6 => 'log_ric_wind',
  7 => 'log_ric_utente_id',
);
    private const WRITABLE = array (
  0 => 'log_ric_hotel_id',
  1 => 'log_ric_dal',
  2 => 'log_ric_al',
  3 => 'log_ric_data',
  4 => 'log_ric_notti',
  5 => 'log_ric_wind',
  6 => 'log_ric_utente_id',
);
    private const FILTERABLE = array (
  0 => 'log_ric_id',
  1 => 'log_ric_hotel_id',
);
    private const SORTABLE = array (
  0 => 'log_ric_id',
  1 => 'log_ric_hotel_id',
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
