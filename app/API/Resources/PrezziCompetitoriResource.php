<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa prezzi_competitori secondo la configurazione del Builder. */
final class PrezziCompetitoriResource
{
    private const READABLE = array (
  0 => 'prezzi_competitori_id',
  1 => 'hotel_id',
  2 => 'data_prezzo',
  3 => 'percentile_10',
  4 => 'percentile_25',
  5 => 'percentile_50',
  6 => 'percentile_75',
  7 => 'percentile_90',
  8 => 'indice_disponibilita',
  9 => 'data_acuisizione',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'data_prezzo',
  2 => 'percentile_10',
  3 => 'percentile_25',
  4 => 'percentile_50',
  5 => 'percentile_75',
  6 => 'percentile_90',
  7 => 'indice_disponibilita',
  8 => 'data_acuisizione',
);
    private const FILTERABLE = array (
  0 => 'prezzi_competitori_id',
  1 => 'hotel_id',
  2 => 'data_prezzo',
);
    private const SORTABLE = array (
  0 => 'prezzi_competitori_id',
  1 => 'hotel_id',
  2 => 'data_prezzo',
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
