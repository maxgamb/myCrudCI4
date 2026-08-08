<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa obmp_cm secondo la configurazione del Builder. */
final class ObmpCmResource
{
    private const READABLE = array (
  0 => 'obmp_cm_id',
  1 => 'hotel_id',
  2 => 'agenzia_id',
  3 => 'obmp_cm_id_hotel_agenzia',
  4 => 'obmp_cm_attiva',
  5 => 'obmp_cm_agenzia_url',
  6 => 'obmp_cm_agenzia_user',
  7 => 'obmp_cm_agenzia_password',
  8 => 'obmp_cm_ws_agenzia_url',
  9 => 'obmp_cm_ws_agenzia_user',
  10 => 'obmp_cm_ws_agenzia_password',
  11 => 'obmp_cm_tipologia_id1',
  12 => 'obmp_cm_room_id1',
  13 => 'obmp_cm_tipologia_id2',
  14 => 'obmp_cm_room_id2',
  15 => 'obmp_cm_tipologia_id3',
  16 => 'obmp_cm_room_id3',
  17 => 'obmp_cm_tipologia_id4',
  18 => 'obmp_cm_room_id4',
  19 => 'obmp_cm_tipologia_id5',
  20 => 'obmp_cm_room_id5',
  21 => 'obmp_cm_tipologia_id6',
  22 => 'obmp_cm_room_id6',
  23 => 'obmp_cm_tipologia_id7',
  24 => 'obmp_cm_room_id7',
  25 => 'obmp_cm_tipologia_id8',
  26 => 'obmp_cm_room_id8',
  27 => 'obmp_cm_tipologia_id9',
  28 => 'obmp_cm_room_id9',
  29 => 'obmp_cm_tipologia_id10',
  30 => 'obmp_cm_room_id10',
  31 => 'obmp_cm_moltiplicatore',
  32 => 'obmp_cm_max_camere',
  33 => 'obmp_cm_min_camare',
  34 => 'obmp_cm_utente_id',
  35 => 'agenzie__agenzia_id__label',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'agenzia_id',
  2 => 'obmp_cm_id_hotel_agenzia',
  3 => 'obmp_cm_attiva',
  4 => 'obmp_cm_agenzia_url',
  5 => 'obmp_cm_agenzia_user',
  6 => 'obmp_cm_agenzia_password',
  7 => 'obmp_cm_ws_agenzia_url',
  8 => 'obmp_cm_ws_agenzia_user',
  9 => 'obmp_cm_ws_agenzia_password',
  10 => 'obmp_cm_tipologia_id1',
  11 => 'obmp_cm_room_id1',
  12 => 'obmp_cm_tipologia_id2',
  13 => 'obmp_cm_room_id2',
  14 => 'obmp_cm_tipologia_id3',
  15 => 'obmp_cm_room_id3',
  16 => 'obmp_cm_tipologia_id4',
  17 => 'obmp_cm_room_id4',
  18 => 'obmp_cm_tipologia_id5',
  19 => 'obmp_cm_room_id5',
  20 => 'obmp_cm_tipologia_id6',
  21 => 'obmp_cm_room_id6',
  22 => 'obmp_cm_tipologia_id7',
  23 => 'obmp_cm_room_id7',
  24 => 'obmp_cm_tipologia_id8',
  25 => 'obmp_cm_room_id8',
  26 => 'obmp_cm_tipologia_id9',
  27 => 'obmp_cm_room_id9',
  28 => 'obmp_cm_tipologia_id10',
  29 => 'obmp_cm_room_id10',
  30 => 'obmp_cm_moltiplicatore',
  31 => 'obmp_cm_max_camere',
  32 => 'obmp_cm_min_camare',
  33 => 'obmp_cm_utente_id',
);
    private const FILTERABLE = array (
  0 => 'obmp_cm_id',
  1 => 'hotel_id',
  2 => 'agenzia_id',
  3 => 'obmp_cm_attiva',
);
    private const SORTABLE = array (
  0 => 'obmp_cm_id',
  1 => 'hotel_id',
  2 => 'agenzia_id',
  3 => 'obmp_cm_attiva',
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
