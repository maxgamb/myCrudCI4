<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa obmp_ref_site secondo la configurazione del Builder. */
final class ObmpRefSiteResource
{
    private const READABLE = array (
  0 => 'ref_site_id',
  1 => 'hotel_id',
  2 => 'obmp_affiliati_id',
  3 => 'ref_site_nome',
  4 => 'ref_site_date_record',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'obmp_affiliati_id',
  2 => 'ref_site_nome',
  3 => 'ref_site_date_record',
);
    private const FILTERABLE = array (
  0 => 'ref_site_id',
  1 => 'hotel_id',
  2 => 'obmp_affiliati_id',
);
    private const SORTABLE = array (
  0 => 'ref_site_id',
  1 => 'hotel_id',
  2 => 'obmp_affiliati_id',
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
