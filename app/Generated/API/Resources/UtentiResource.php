<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa utenti secondo la configurazione del Builder. */
final class UtentiResource
{
    private const READABLE = array (
  0 => 'Utente_id',
  1 => 'staff_id',
  2 => 'Nome_Utente',
  3 => 'Pass_Utente',
  4 => 'Email_Utente',
  5 => 'hotel_id',
  6 => 'utenti_livello',
  7 => 'utenti_Utente_id',
  8 => 'staff_nome',
);
    private const WRITABLE = array (
  0 => 'staff_id',
  1 => 'Nome_Utente',
  2 => 'Pass_Utente',
  3 => 'Email_Utente',
  4 => 'hotel_id',
  5 => 'utenti_livello',
  6 => 'utenti_Utente_id',
);
    private const FILTERABLE = array (
  0 => 'Utente_id',
  1 => 'staff_id',
  2 => 'hotel_id',
);
    private const SORTABLE = array (
  0 => 'Utente_id',
  1 => 'staff_id',
  2 => 'hotel_id',
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
