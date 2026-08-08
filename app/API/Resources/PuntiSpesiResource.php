<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa punti_spesi secondo la configurazione del Builder. */
final class PuntiSpesiResource
{
    private const READABLE = array (
  0 => 'punti_spesi_id',
  1 => 'hotel_id',
  2 => 'cliente_id',
  3 => 'conto_id',
  4 => 'punti',
  5 => 'data',
  6 => 'utente_id',
  7 => 'clienti__cliente_id__label',
  8 => 'conti__conto_id__label',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'cliente_id',
  2 => 'conto_id',
  3 => 'punti',
  4 => 'data',
  5 => 'utente_id',
);
    private const FILTERABLE = array (
  0 => 'punti_spesi_id',
  1 => 'hotel_id',
  2 => 'cliente_id',
  3 => 'conto_id',
);
    private const SORTABLE = array (
  0 => 'punti_spesi_id',
  1 => 'hotel_id',
  2 => 'cliente_id',
  3 => 'conto_id',
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
