<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa obmp_cancellations secondo la configurazione del Builder. */
final class ObmpCancellationsResource
{
    private const READABLE = array (
  0 => 'obmp_cancellation_id',
  1 => 'obmp_cancellation_cod',
  2 => 'obmp_cancellation_title',
  3 => 'obmp_cancellation',
  4 => 'obmp_cancellation_day',
  5 => 'cancellation_lg',
);
    private const WRITABLE = array (
  0 => 'obmp_cancellation_cod',
  1 => 'obmp_cancellation_title',
  2 => 'obmp_cancellation',
  3 => 'obmp_cancellation_day',
  4 => 'cancellation_lg',
);
    private const FILTERABLE = array (
  0 => 'obmp_cancellation_id',
  1 => 'obmp_cancellation_cod',
);
    private const SORTABLE = array (
  0 => 'obmp_cancellation_id',
  1 => 'obmp_cancellation_cod',
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
