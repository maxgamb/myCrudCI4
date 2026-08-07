<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa costi_var secondo la configurazione del Builder. */
final class CostiVarResource
{
    private const READABLE = array (
  0 => 'costi_var_id',
  1 => 'costi_area_id',
  2 => 'costi_var_sub_1',
  3 => 'costi_var_sub_2',
  4 => 'hotel_id',
  5 => 'costi_var_codice',
  6 => 'costi_var_nome',
  7 => 'costi_var_deposito',
  8 => 'mag_quantita',
  9 => 'costi_var_prezzo_uso',
  10 => 'mag_prezzo_lavaggio',
  11 => 'costi_var_addebbito',
  12 => 'costi_area_costi_area_nome',
);
    private const WRITABLE = array (
  0 => 'costi_area_id',
  1 => 'costi_var_sub_1',
  2 => 'costi_var_sub_2',
  3 => 'hotel_id',
  4 => 'costi_var_codice',
  5 => 'costi_var_nome',
  6 => 'costi_var_deposito',
  7 => 'mag_quantita',
  8 => 'costi_var_prezzo_uso',
  9 => 'mag_prezzo_lavaggio',
  10 => 'costi_var_addebbito',
);
    private const FILTERABLE = array (
  0 => 'costi_var_id',
  1 => 'costi_area_id',
);
    private const SORTABLE = array (
  0 => 'costi_var_id',
  1 => 'costi_area_id',
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
