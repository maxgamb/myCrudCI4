<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa listino_periodi_obmp secondo la configurazione del Builder. */
final class ListinoPeriodiObmpResource
{
    private const READABLE = array (
  0 => 'listino_periodi_id',
  1 => 'listino_nome_id',
  2 => 'listino_periodi_flex',
  3 => 'listino_dal',
  4 => 'listino_al',
  5 => 'hotel_id',
  6 => 'listino_periodi',
  7 => 'listino_nome_obmp__listino_nome_id__label',
);
    private const WRITABLE = array (
  0 => 'listino_nome_id',
  1 => 'listino_periodi_flex',
  2 => 'listino_dal',
  3 => 'listino_al',
  4 => 'hotel_id',
  5 => 'listino_periodi',
);
    private const FILTERABLE = array (
  0 => 'listino_periodi_id',
  1 => 'listino_nome_id',
  2 => 'listino_dal',
);
    private const SORTABLE = array (
  0 => 'listino_periodi_id',
  1 => 'listino_nome_id',
  2 => 'listino_dal',
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
