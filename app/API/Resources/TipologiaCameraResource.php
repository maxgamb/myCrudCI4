<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa tipologia_camera secondo la configurazione del Builder. */
final class TipologiaCameraResource
{
    private const READABLE = array (
  0 => 'tipologia_id',
  1 => 'nome_tipologia',
  2 => 'nome_tipologia_en',
  3 => 'nome_tipologia_fr',
  4 => 'nome_tipologia_de',
  5 => 'nome_tipologia_sp',
  6 => 'nome_tipologia_jp',
  7 => 'tipologia_sigla',
  8 => 'numero_pax',
  9 => 'tipologia_camera_utente_id',
  10 => 'perc_prezzo',
);
    private const WRITABLE = array (
  0 => 'nome_tipologia',
  1 => 'nome_tipologia_en',
  2 => 'nome_tipologia_fr',
  3 => 'nome_tipologia_de',
  4 => 'nome_tipologia_sp',
  5 => 'nome_tipologia_jp',
  6 => 'tipologia_sigla',
  7 => 'numero_pax',
  8 => 'tipologia_camera_utente_id',
  9 => 'perc_prezzo',
);
    private const FILTERABLE = array (
  0 => 'tipologia_id',
);
    private const SORTABLE = array (
  0 => 'tipologia_id',
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
