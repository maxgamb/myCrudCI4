<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa camere_nesting secondo la configurazione del Builder. */
final class CamereNestingResource
{
    private const READABLE = array (
  0 => 'nesting_id',
  1 => 'camara_id',
  2 => 'tipologia_id',
  3 => 'voto',
  4 => 'nesting_utente_id',
);
    private const WRITABLE = array (
  0 => 'camara_id',
  1 => 'tipologia_id',
  2 => 'voto',
  3 => 'nesting_utente_id',
);
    private const FILTERABLE = array (
  0 => 'nesting_id',
  1 => 'camara_id',
  2 => 'tipologia_id',
);
    private const SORTABLE = array (
  0 => 'nesting_id',
  1 => 'camara_id',
  2 => 'tipologia_id',
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
