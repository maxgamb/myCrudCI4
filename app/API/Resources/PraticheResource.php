<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa pratiche secondo la configurazione del Builder. */
final class PraticheResource
{
    private const READABLE = array (
  0 => 'pratica_id',
  1 => 'hotel_id',
  2 => 'pratica_nome',
  3 => 'pratica_agenzia_id',
  4 => 'pratica_1',
  5 => 'pratica_2',
  6 => 'pratica_note',
  7 => 'pratica_stato',
  8 => 'pratiche_utente_id',
  9 => 'agenzie_agenzia_tipologia',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'pratica_nome',
  2 => 'pratica_agenzia_id',
  3 => 'pratica_1',
  4 => 'pratica_2',
  5 => 'pratica_note',
  6 => 'pratica_stato',
  7 => 'pratiche_utente_id',
);
    private const FILTERABLE = array (
  0 => 'pratica_id',
  1 => 'hotel_id',
  2 => 'pratica_agenzia_id',
);
    private const SORTABLE = array (
  0 => 'pratica_id',
  1 => 'hotel_id',
  2 => 'pratica_agenzia_id',
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
