<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa woucher secondo la configurazione del Builder. */
final class WoucherResource
{
    private const READABLE = array (
  0 => 'woucher_id',
  1 => 'woucher_agenzia_id',
  2 => 'woucher_preno_id',
  3 => 'woucher_hotel_id',
  4 => 'woucher_in',
  5 => 'woucher_notti',
  6 => 'woucher_out',
  7 => 'woucher_numero',
  8 => 'woucher_serie',
  9 => 'woucher_singole',
  10 => 'woucher_singole_staff',
  11 => 'woucher_doppia',
  12 => 'woucher_tripla',
  13 => 'woucher_quadrupla',
  14 => 'woucher_cildren_n',
  15 => 'woucher_doppia_studenti',
  16 => 'woucher_tripla_studenti',
  17 => 'woucher_quadrupla_studenti',
  18 => 'woucher_quintupla_studenti',
  19 => 'woucher_tot_pax',
  20 => 'woucher_tot_adulti',
  21 => 'woucher_tot_studenti',
  22 => 'woucher_note',
);
    private const WRITABLE = array (
  0 => 'woucher_agenzia_id',
  1 => 'woucher_preno_id',
  2 => 'woucher_hotel_id',
  3 => 'woucher_in',
  4 => 'woucher_notti',
  5 => 'woucher_out',
  6 => 'woucher_numero',
  7 => 'woucher_serie',
  8 => 'woucher_singole',
  9 => 'woucher_singole_staff',
  10 => 'woucher_doppia',
  11 => 'woucher_tripla',
  12 => 'woucher_quadrupla',
  13 => 'woucher_cildren_n',
  14 => 'woucher_doppia_studenti',
  15 => 'woucher_tripla_studenti',
  16 => 'woucher_quadrupla_studenti',
  17 => 'woucher_quintupla_studenti',
  18 => 'woucher_tot_pax',
  19 => 'woucher_tot_adulti',
  20 => 'woucher_tot_studenti',
  21 => 'woucher_note',
);
    private const FILTERABLE = array (
  0 => 'woucher_id',
);
    private const SORTABLE = array (
  0 => 'woucher_id',
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
