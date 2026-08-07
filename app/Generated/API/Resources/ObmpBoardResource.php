<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa obmp_board secondo la configurazione del Builder. */
final class ObmpBoardResource
{
    private const READABLE = array (
  0 => 'obmp_board_id',
  1 => 'obmp_board_title',
  2 => 'obmp_board',
  3 => 'obmp_board_cod',
  4 => 'board_lg',
);
    private const WRITABLE = array (
  0 => 'obmp_board_id',
  1 => 'obmp_board_title',
  2 => 'obmp_board',
  3 => 'obmp_board_cod',
  4 => 'board_lg',
);
    private const FILTERABLE = array (
  0 => 'obmp_board_id',
  1 => 'obmp_board_title',
  2 => 'obmp_board_cod',
);
    private const SORTABLE = array (
  0 => 'obmp_board_id',
  1 => 'obmp_board_title',
  2 => 'obmp_board_cod',
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
