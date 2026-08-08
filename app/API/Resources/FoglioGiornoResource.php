<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa foglio_giorno secondo la configurazione del Builder. */
final class FoglioGiornoResource
{
    private const READABLE = array (
  0 => 'foglio_id',
  1 => 'hotel_id',
  2 => 'conto_id',
  3 => 'camera_id',
  4 => 'preno_id',
  5 => 'tipologia_id',
  6 => 'numero_camera',
  7 => 'foglio_prezzo_camera',
  8 => 'date_foglio',
  9 => 'nome_cliente',
  10 => 'cognome_cliente',
  11 => 'in_conto',
  12 => 'out_preno',
  13 => 'stato_camera',
  14 => 'preno_agenzia',
  15 => 'foglio_utente_id',
  16 => 'agenda__preno_id__label',
  17 => 'agenzie__preno_agenzia__label',
  18 => 'camere__camera_id__label',
  19 => 'tipologia_camera__tipologia_id__label',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'conto_id',
  2 => 'camera_id',
  3 => 'preno_id',
  4 => 'tipologia_id',
  5 => 'numero_camera',
  6 => 'foglio_prezzo_camera',
  7 => 'date_foglio',
  8 => 'nome_cliente',
  9 => 'cognome_cliente',
  10 => 'in_conto',
  11 => 'out_preno',
  12 => 'stato_camera',
  13 => 'preno_agenzia',
  14 => 'foglio_utente_id',
);
    private const FILTERABLE = array (
  0 => 'foglio_id',
  1 => 'hotel_id',
  2 => 'conto_id',
  3 => 'camera_id',
  4 => 'preno_id',
  5 => 'tipologia_id',
  6 => 'foglio_prezzo_camera',
  7 => 'date_foglio',
  8 => 'in_conto',
  9 => 'out_preno',
  10 => 'stato_camera',
  11 => 'preno_agenzia',
);
    private const SORTABLE = array (
  0 => 'foglio_id',
  1 => 'hotel_id',
  2 => 'conto_id',
  3 => 'camera_id',
  4 => 'preno_id',
  5 => 'tipologia_id',
  6 => 'foglio_prezzo_camera',
  7 => 'date_foglio',
  8 => 'in_conto',
  9 => 'out_preno',
  10 => 'stato_camera',
  11 => 'preno_agenzia',
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
