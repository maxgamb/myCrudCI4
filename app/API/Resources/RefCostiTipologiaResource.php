<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa ref_costi_tipologia secondo la configurazione del Builder. */
final class RefCostiTipologiaResource
{
    private const READABLE = array (
  0 => 'ref_costi_tipologia_id',
  1 => 'costi_var_id',
  2 => 'tipologia_id',
  3 => 'hotel_id',
  4 => 'stay',
  5 => 'days',
  6 => 'check_out',
  7 => 'utente_id',
  8 => 'costi_var_costi_var_sub_1',
  9 => 'tipologia_camera_nome_tipologia',
);
    private const WRITABLE = array (
  0 => 'costi_var_id',
  1 => 'tipologia_id',
  2 => 'hotel_id',
  3 => 'stay',
  4 => 'days',
  5 => 'check_out',
  6 => 'utente_id',
);
    private const FILTERABLE = array (
  0 => 'ref_costi_tipologia_id',
  1 => 'costi_var_id',
  2 => 'tipologia_id',
);
    private const SORTABLE = array (
  0 => 'ref_costi_tipologia_id',
  1 => 'costi_var_id',
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
