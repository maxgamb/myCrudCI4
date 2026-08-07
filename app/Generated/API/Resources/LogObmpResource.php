<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa log_obmp secondo la configurazione del Builder. */
final class LogObmpResource
{
    private const READABLE = array (
  0 => 'log_obmp_id',
  1 => 'preno_dal',
  2 => 'preno_al',
  3 => 'Q1',
  4 => 'T1',
  5 => 'hotel_id',
  6 => 'ref_site',
  7 => 'ref_agency',
  8 => 'ref_event',
  9 => 'ref_session',
  10 => 'ref_cookie',
  11 => 'mygooglekeyword',
  12 => 'log_obmp_daterecord',
);
    private const WRITABLE = array (
  0 => 'preno_dal',
  1 => 'preno_al',
  2 => 'Q1',
  3 => 'T1',
  4 => 'hotel_id',
  5 => 'ref_site',
  6 => 'ref_agency',
  7 => 'ref_event',
  8 => 'ref_session',
  9 => 'ref_cookie',
  10 => 'mygooglekeyword',
  11 => 'log_obmp_daterecord',
);
    private const FILTERABLE = array (
  0 => 'log_obmp_id',
  1 => 'preno_dal',
  2 => 'preno_al',
  3 => 'hotel_id',
  4 => 'ref_site',
  5 => 'ref_agency',
  6 => 'ref_event',
  7 => 'ref_session',
  8 => 'ref_cookie',
);
    private const SORTABLE = array (
  0 => 'log_obmp_id',
  1 => 'preno_dal',
  2 => 'preno_al',
  3 => 'hotel_id',
  4 => 'ref_site',
  5 => 'ref_agency',
  6 => 'ref_event',
  7 => 'ref_session',
  8 => 'ref_cookie',
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
