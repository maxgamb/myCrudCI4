<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa obmp_quote_sub secondo la configurazione del Builder. */
final class ObmpQuoteSubResource
{
    private const READABLE = array (
  0 => 'obmp_quote_sub_id',
  1 => 'obmp_quote_id',
  2 => 'hotel_id',
  3 => 'quote_sub_jeson',
  4 => 'quote_sub_data',
  5 => 'randomd_string',
  6 => 'obmp_quote_quote_lg',
);
    private const WRITABLE = array (
  0 => 'obmp_quote_id',
  1 => 'hotel_id',
  2 => 'quote_sub_jeson',
  3 => 'quote_sub_data',
  4 => 'randomd_string',
);
    private const FILTERABLE = array (
  0 => 'obmp_quote_sub_id',
  1 => 'obmp_quote_id',
);
    private const SORTABLE = array (
  0 => 'obmp_quote_sub_id',
  1 => 'obmp_quote_id',
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
