<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa ci_sessions secondo la configurazione del Builder. */
final class CiSessionsResource
{
    private const READABLE = array (
  0 => 'id',
  1 => 'ip_address',
  2 => 'timestamp',
);
    private const WRITABLE = array (
  0 => 'id',
  1 => 'ip_address',
  2 => 'timestamp',
  3 => 'data',
);
    private const FILTERABLE = array (
  0 => 'id',
  1 => 'timestamp',
);
    private const SORTABLE = array (
  0 => 'id',
  1 => 'timestamp',
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
