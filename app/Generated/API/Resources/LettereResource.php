<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa lettere secondo la configurazione del Builder. */
final class LettereResource
{
    private const READABLE = array (
  0 => 'lettere_id',
  1 => 'etichetta',
  2 => 'hotel_id',
  3 => 'titolo',
  4 => 'reparto',
  5 => 'contoller',
  6 => 'en',
  7 => 'it',
  8 => 'es',
  9 => 'fr',
  10 => 'de',
  11 => 'data_stamp',
);
    private const WRITABLE = array (
  0 => 'etichetta',
  1 => 'hotel_id',
  2 => 'titolo',
  3 => 'reparto',
  4 => 'contoller',
  5 => 'en',
  6 => 'it',
  7 => 'es',
  8 => 'fr',
  9 => 'de',
  10 => 'data_stamp',
);
    private const FILTERABLE = array (
  0 => 'lettere_id',
  1 => 'etichetta',
  2 => 'reparto',
);
    private const SORTABLE = array (
  0 => 'lettere_id',
  1 => 'etichetta',
  2 => 'reparto',
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
