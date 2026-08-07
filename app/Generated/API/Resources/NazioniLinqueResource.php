<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa nazioni_linque secondo la configurazione del Builder. */
final class NazioniLinqueResource
{
    private const READABLE = array (
  0 => 'isoKey',
  1 => 'iso3',
  2 => 'nazioni_EN',
  3 => 'nazioni_ES',
  4 => 'nazioni_FR',
  5 => 'nazioni_DE',
  6 => 'nazioni_IT',
  7 => 'lg',
);
    private const WRITABLE = array (
  0 => 'isoKey',
  1 => 'iso3',
  2 => 'nazioni_EN',
  3 => 'nazioni_ES',
  4 => 'nazioni_FR',
  5 => 'nazioni_DE',
  6 => 'nazioni_IT',
  7 => 'lg',
);
    private const FILTERABLE = array (
  0 => 'isoKey',
);
    private const SORTABLE = array (
  0 => 'isoKey',
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
