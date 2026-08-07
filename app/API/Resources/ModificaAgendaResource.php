<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa modifica_agenda secondo la configurazione del Builder. */
final class ModificaAgendaResource
{
    private const READABLE = array (
  0 => 'mod_agenda_id',
  1 => 'mod_preno_id',
  2 => 'mod_agenda_valori',
  3 => 'mod_preno_data_records',
  4 => 'modifica_agenda_adebiti_utente_id',
  5 => 'agenda_preno_arr_ore',
);
    private const WRITABLE = array (
  0 => 'mod_preno_id',
  1 => 'mod_agenda_valori',
  2 => 'mod_preno_data_records',
  3 => 'modifica_agenda_adebiti_utente_id',
);
    private const FILTERABLE = array (
  0 => 'mod_agenda_id',
  1 => 'mod_preno_id',
);
    private const SORTABLE = array (
  0 => 'mod_agenda_id',
  1 => 'mod_preno_id',
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
