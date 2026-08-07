<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa obmp_ref_event secondo la configurazione del Builder. */
final class ObmpRefEventResource
{
    private const READABLE = array (
  0 => 'ref_event_id',
  1 => 'ref_site_id',
  2 => 'hotel_id',
  3 => 'listino_nome_id',
  4 => 'agenzia_id',
  5 => 'ref_event_nome',
  6 => 'event_dal',
  7 => 'event_al',
  8 => 'ref_event_note',
  9 => 'agenzie_agenzia_tipologia',
  10 => 'listino_nome_obmp_listino_nome',
  11 => 'obmp_ref_site_ref_site_nome',
);
    private const WRITABLE = array (
  0 => 'ref_site_id',
  1 => 'hotel_id',
  2 => 'listino_nome_id',
  3 => 'agenzia_id',
  4 => 'ref_event_nome',
  5 => 'event_dal',
  6 => 'event_al',
  7 => 'ref_event_note',
);
    private const FILTERABLE = array (
  0 => 'ref_event_id',
  1 => 'ref_site_id',
  2 => 'hotel_id',
  3 => 'listino_nome_id',
  4 => 'agenzia_id',
);
    private const SORTABLE = array (
  0 => 'ref_event_id',
  1 => 'ref_site_id',
  2 => 'hotel_id',
  3 => 'listino_nome_id',
  4 => 'agenzia_id',
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
