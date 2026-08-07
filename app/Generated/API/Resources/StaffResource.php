<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa staff secondo la configurazione del Builder. */
final class StaffResource
{
    private const READABLE = array (
  0 => 'staff_id',
  1 => 'cognome',
  2 => 'nome',
  3 => 'citta',
  4 => 'provincia',
  5 => 'staff_nazione',
  6 => 'indirizzo',
  7 => 'telefono',
  8 => 'cellulare',
  9 => 'email',
  10 => 'genere',
  11 => 'reparto_id',
  12 => 'staff_stato',
  13 => 'staff_datarecod',
  14 => 'utente_id',
);
    private const WRITABLE = array (
  0 => 'cognome',
  1 => 'nome',
  2 => 'citta',
  3 => 'provincia',
  4 => 'staff_nazione',
  5 => 'indirizzo',
  6 => 'telefono',
  7 => 'cellulare',
  8 => 'email',
  9 => 'genere',
  10 => 'reparto_id',
  11 => 'staff_stato',
  12 => 'staff_datarecod',
  13 => 'utente_id',
);
    private const FILTERABLE = array (
  0 => 'staff_id',
);
    private const SORTABLE = array (
  0 => 'staff_id',
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
