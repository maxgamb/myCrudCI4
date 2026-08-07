<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa obmp_cm_lingue secondo la configurazione del Builder. */
final class ObmpCmLingueResource
{
    private const READABLE = array (
  0 => 'obmp_cm_lingue_id',
  1 => 'obmp_cm_rooms_id',
  2 => 'hotel_id',
  3 => 'obmp_cm_lingue_codice',
  4 => 'obmp_cm_lingue_nome',
  5 => 'obmp_cm_lingue_descrizione',
  6 => 'obmp_cm_lingue_html1',
  7 => 'obmp_cm_lingue_html2',
  8 => 'obmp_cm_lingue_html3',
  9 => 'obmp_cm_lingue_note',
  10 => 'obmp_cm_lingue_politiche',
  11 => 'obmp_cm_lingue_condizioni',
  12 => 'obmp_cm_lingue_utente_id',
  13 => 'obmp_cm_rooms_obmp_cm_rooms_room_note',
);
    private const WRITABLE = array (
  0 => 'obmp_cm_rooms_id',
  1 => 'hotel_id',
  2 => 'obmp_cm_lingue_codice',
  3 => 'obmp_cm_lingue_nome',
  4 => 'obmp_cm_lingue_descrizione',
  5 => 'obmp_cm_lingue_html1',
  6 => 'obmp_cm_lingue_html2',
  7 => 'obmp_cm_lingue_html3',
  8 => 'obmp_cm_lingue_note',
  9 => 'obmp_cm_lingue_politiche',
  10 => 'obmp_cm_lingue_condizioni',
  11 => 'obmp_cm_lingue_utente_id',
);
    private const FILTERABLE = array (
  0 => 'obmp_cm_lingue_id',
  1 => 'obmp_cm_rooms_id',
);
    private const SORTABLE = array (
  0 => 'obmp_cm_lingue_id',
  1 => 'obmp_cm_rooms_id',
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
