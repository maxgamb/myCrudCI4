<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa obmp_affiliati secondo la configurazione del Builder. */
final class ObmpAffiliatiResource
{
    private const READABLE = array (
  0 => 'obmp_affiliati_id',
  1 => 'obmp_aff_societa',
  2 => 'obmp_aff_sito',
  3 => 'obmp_aff_email',
  4 => 'obmp_aff_pasword',
  5 => 'obmp_aff_cookies',
  6 => 'obmp_aff_commisione',
  7 => 'obmp_aff_mark_up',
);
    private const WRITABLE = array (
  0 => 'obmp_aff_societa',
  1 => 'obmp_aff_sito',
  2 => 'obmp_aff_email',
  3 => 'obmp_aff_pasword',
  4 => 'obmp_aff_cookies',
  5 => 'obmp_aff_commisione',
  6 => 'obmp_aff_mark_up',
);
    private const FILTERABLE = array (
  0 => 'obmp_affiliati_id',
);
    private const SORTABLE = array (
  0 => 'obmp_affiliati_id',
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
