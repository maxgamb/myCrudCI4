<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa obmp_cm_rooms secondo la configurazione del Builder. */
final class ObmpCmRoomsResource
{
    private const READABLE = array (
  0 => 'obmp_cm_rooms_id',
  1 => 'obmp_cm_id',
  2 => 'hotel_id',
  3 => 'obmp_cm_rooms_room_id',
  4 => 'obmp_cm_rooms_attiva',
  5 => 'obmp_cm_rooms_tipologia_id',
  6 => 'obmp_cm_rooms_room_note',
  7 => 'obmp_cm_rooms_room_var_prezzo',
  8 => 'obmp_cm_rooms_room_min_prezzo',
  9 => 'obmp_cm_rooms_trattamento',
  10 => 'obmp_cm_rooms_max_pax',
  11 => 'obmp_cm_rooms_max_room',
  12 => 'obmp_cm_rooms_nesting',
  13 => 'citytax',
  14 => 'obmp_cm_rooms_foto',
  15 => 'obmp_cm_rooms_foto150',
  16 => 'obmp_cm_rooms_foto270',
  17 => 'obmp_cm_rooms_foto700',
  18 => 'obmp_cm_rooms_utente_id',
  19 => 'obmp_cm_obmp_cm_id_hotel_agenzia',
  20 => 'tipologia_camera_nome_tipologia',
);
    private const WRITABLE = array (
  0 => 'obmp_cm_id',
  1 => 'hotel_id',
  2 => 'obmp_cm_rooms_room_id',
  3 => 'obmp_cm_rooms_attiva',
  4 => 'obmp_cm_rooms_tipologia_id',
  5 => 'obmp_cm_rooms_room_note',
  6 => 'obmp_cm_rooms_room_var_prezzo',
  7 => 'obmp_cm_rooms_room_min_prezzo',
  8 => 'obmp_cm_rooms_trattamento',
  9 => 'obmp_cm_rooms_max_pax',
  10 => 'obmp_cm_rooms_max_room',
  11 => 'obmp_cm_rooms_nesting',
  12 => 'citytax',
  13 => 'obmp_cm_rooms_foto',
  14 => 'obmp_cm_rooms_foto150',
  15 => 'obmp_cm_rooms_foto270',
  16 => 'obmp_cm_rooms_foto700',
  17 => 'obmp_cm_rooms_utente_id',
);
    private const FILTERABLE = array (
  0 => 'obmp_cm_rooms_id',
  1 => 'obmp_cm_id',
  2 => 'obmp_cm_rooms_attiva',
  3 => 'obmp_cm_rooms_tipologia_id',
);
    private const SORTABLE = array (
  0 => 'obmp_cm_rooms_id',
  1 => 'obmp_cm_id',
  2 => 'obmp_cm_rooms_attiva',
  3 => 'obmp_cm_rooms_tipologia_id',
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
