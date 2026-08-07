<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa ref_obmp_booking secondo la configurazione del Builder. */
final class RefObmpBookingResource
{
    private const READABLE = array (
  0 => 'ref_obm_data',
  1 => 'preno_id',
  2 => 'obm_cliente_id',
  3 => 'hotel_id',
  4 => 'ref_site',
  5 => 'ref_agency',
  6 => 'ref_event',
  7 => 'ref_session',
  8 => 'ref_cookie',
  9 => 'room_obmp_string',
  10 => 'quote_id',
  11 => 'agenda_preno_arr_ore',
  12 => 'obmp_clienti_obm_cliente_first_name',
  13 => 'obmp_quote_quote_lg',
  14 => 'obmp_ref_site_ref_site_nome',
);
    private const WRITABLE = array (
  0 => 'ref_obm_data',
  1 => 'preno_id',
  2 => 'obm_cliente_id',
  3 => 'hotel_id',
  4 => 'ref_site',
  5 => 'ref_agency',
  6 => 'ref_event',
  7 => 'ref_session',
  8 => 'ref_cookie',
  9 => 'room_obmp_string',
  10 => 'quote_id',
);
    private const FILTERABLE = array (
  0 => 'ref_obm_data',
  1 => 'preno_id',
  2 => 'obm_cliente_id',
  3 => 'hotel_id',
  4 => 'ref_site',
  5 => 'quote_id',
);
    private const SORTABLE = array (
  0 => 'ref_obm_data',
  1 => 'preno_id',
  2 => 'obm_cliente_id',
  3 => 'hotel_id',
  4 => 'ref_site',
  5 => 'quote_id',
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
