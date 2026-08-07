<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa tex_lingue secondo la configurazione del Builder. */
final class TexLingueResource
{
    private const READABLE = array (
  0 => 'tex_lingue_id',
  1 => 'etichetta_lg',
  2 => 'en',
  3 => 'it',
  4 => 'es',
  5 => 'fr',
  6 => 'de',
  7 => 'reparto_id',
);
    private const WRITABLE = array (
  0 => 'etichetta_lg',
  1 => 'en',
  2 => 'it',
  3 => 'es',
  4 => 'fr',
  5 => 'de',
  6 => 'reparto_id',
);
    private const FILTERABLE = array (
  0 => 'tex_lingue_id',
  1 => 'etichetta_lg',
  2 => 'reparto_id',
);
    private const SORTABLE = array (
  0 => 'tex_lingue_id',
  1 => 'etichetta_lg',
  2 => 'reparto_id',
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
