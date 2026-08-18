<?php

declare(strict_types=1);

namespace App\API\Resources;

/**
 * Output-only serializer for `film`.
 *
 * It performs no queries, request parsing, validation, or persistence.
 */
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
  13 => 'uploads',
  14 => 'language_id__label',
  15 => 'original_language_id__label',
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
}
