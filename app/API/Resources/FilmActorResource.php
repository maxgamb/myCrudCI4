<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa film_actor secondo la configurazione del Builder. */
final class FilmActorResource
{
    private const READABLE = array (
  0 => 'actor_id',
  1 => 'film_id',
  2 => 'last_update',
  3 => 'actor_id__label',
  4 => 'film_id__label',
);
    private const WRITABLE = array (
);
    private const FILTERABLE = array (
  0 => 'actor_id',
  1 => 'film_id',
);
    private const SORTABLE = array (
  0 => 'actor_id',
  1 => 'film_id',
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
