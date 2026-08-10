<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa film secondo la configurazione del Builder. */
final class FilmResource
{
    private const READABLE = array (
  0 => 'film_id',
  1 => 'title',
  2 => 'description',
  3 => 'release_year',
  4 => 'language_id',
  5 => 'original_language_id',
  6 => 'rental_duration',
  7 => 'rental_rate',
  8 => 'length',
  9 => 'replacement_cost',
  10 => 'rating',
  11 => 'special_features',
  12 => 'last_update',
  13 => 'language_id__label',
  14 => 'original_language_id__label',
);
    private const WRITABLE = array (
  0 => 'title',
  1 => 'description',
  2 => 'release_year',
  3 => 'language_id',
  4 => 'original_language_id',
  5 => 'rental_duration',
  6 => 'rental_rate',
  7 => 'length',
  8 => 'replacement_cost',
  9 => 'rating',
  10 => 'special_features',
);
    private const FILTERABLE = array (
  0 => 'film_id',
  1 => 'title',
  2 => 'language_id',
  3 => 'original_language_id',
);
    private const SORTABLE = array (
  0 => 'film_id',
  1 => 'title',
  2 => 'language_id',
  3 => 'original_language_id',
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
