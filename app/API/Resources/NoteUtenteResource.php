<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa note_utente secondo la configurazione del Builder. */
final class NoteUtenteResource
{
    private const READABLE = array (
  0 => 'note_utente_id',
  1 => 'note_utente_rispondi_id',
  2 => 'Utente_id',
  3 => 'hotel_id',
  4 => 'reparto',
  5 => 'titolo',
  6 => 'note_utente_per',
  7 => 'note_utente_stato',
  8 => 'note_utente_dal',
  9 => 'note_utente_al',
  10 => 'note_utente_data',
  11 => 'utenti_Nome_Utente',
);
    private const WRITABLE = array (
  0 => 'note_utente_rispondi_id',
  1 => 'Utente_id',
  2 => 'hotel_id',
  3 => 'reparto',
  4 => 'titolo',
  5 => 'note_utente_tex',
  6 => 'note_utente_per',
  7 => 'note_utente_stato',
  8 => 'note_utente_dal',
  9 => 'note_utente_al',
  10 => 'note_utente_data',
);
    private const FILTERABLE = array (
  0 => 'note_utente_id',
  1 => 'Utente_id',
);
    private const SORTABLE = array (
  0 => 'note_utente_id',
  1 => 'Utente_id',
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
