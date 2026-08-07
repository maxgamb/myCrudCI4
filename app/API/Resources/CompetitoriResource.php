<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa competitori secondo la configurazione del Builder. */
final class CompetitoriResource
{
    private const READABLE = array (
  0 => 'competitore_id',
  1 => 'hotel_id',
  2 => 'livello_dicompetizione',
  3 => 'competitore_nome',
  4 => 'competitore_venere_id',
  5 => 'qualita_trivago',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'livello_dicompetizione',
  2 => 'competitore_nome',
  3 => 'competitore_venere_id',
  4 => 'qualita_trivago',
);
    private const FILTERABLE = array (
  0 => 'competitore_id',
  1 => 'hotel_id',
);
    private const SORTABLE = array (
  0 => 'competitore_id',
  1 => 'hotel_id',
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
