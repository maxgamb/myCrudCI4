<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa listino_obmp secondo la configurazione del Builder. */
final class ListinoObmpResource
{
    private const READABLE = array (
  0 => 'listino_id',
  1 => 'hotel_id',
  2 => 'listino_nome_id',
  3 => 'tipologia_id',
  4 => 'listino_prezzo',
  5 => 'ref_site',
  6 => 'ref_agency',
  7 => 'ref_event',
  8 => 'ref_session',
  9 => 'ref_cookie',
  10 => 'listino_obmp_datarecord',
  11 => 'listino_nome_obmp_listino_nome',
  12 => 'obmp_cm_rooms_obmp_cm_rooms_room_note',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'listino_nome_id',
  2 => 'tipologia_id',
  3 => 'listino_prezzo',
  4 => 'ref_site',
  5 => 'ref_agency',
  6 => 'ref_event',
  7 => 'ref_session',
  8 => 'ref_cookie',
  9 => 'listino_obmp_datarecord',
);
    private const FILTERABLE = array (
  0 => 'listino_id',
  1 => 'hotel_id',
  2 => 'listino_nome_id',
  3 => 'tipologia_id',
);
    private const SORTABLE = array (
  0 => 'listino_id',
  1 => 'hotel_id',
  2 => 'listino_nome_id',
  3 => 'tipologia_id',
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
