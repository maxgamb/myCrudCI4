<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa log_in secondo la configurazione del Builder. */
final class LogInResource
{
    private const READABLE = array (
  0 => 'log_in_id',
  1 => 'log_nome',
  2 => 'log_pass',
  3 => 'log_ip',
  4 => 'log_out',
  5 => 'log_time',
);
    private const WRITABLE = array (
  0 => 'log_nome',
  1 => 'log_pass',
  2 => 'log_ip',
  3 => 'log_out',
  4 => 'log_time',
);
    private const FILTERABLE = array (
  0 => 'log_in_id',
);
    private const SORTABLE = array (
  0 => 'log_in_id',
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
