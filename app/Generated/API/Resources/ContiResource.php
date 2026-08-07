<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa conti secondo la configurazione del Builder. */
final class ContiResource
{
    private const READABLE = array (
  0 => 'conto_id',
  1 => 'hotel_id',
  2 => 'foglio_id',
  3 => 'clienti_id',
  4 => 'in_conto',
  5 => 'in_conto_time',
  6 => 'out_preno',
  7 => 'out_conto',
  8 => 'preno_id',
  9 => 'camera_id',
  10 => 'numero_camera',
  11 => 'trattamento_sog',
  12 => 'tipo_camera',
  13 => 'tipologia_id',
  14 => 'prezzo',
  15 => 'nome_cliente',
  16 => 'cognome_cliente',
  17 => 'preno_agenzia',
  18 => 'mercato',
  19 => 'conti_stato_camere',
  20 => 'acconto',
  21 => 'conto_pag_modalita',
  22 => 'conti_utente_id',
  23 => 'camere_tipologia_camera',
  24 => 'foglio_giorno_date_foglio',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'foglio_id',
  2 => 'clienti_id',
  3 => 'in_conto',
  4 => 'in_conto_time',
  5 => 'out_preno',
  6 => 'out_conto',
  7 => 'preno_id',
  8 => 'camera_id',
  9 => 'numero_camera',
  10 => 'trattamento_sog',
  11 => 'tipo_camera',
  12 => 'tipologia_id',
  13 => 'prezzo',
  14 => 'nome_cliente',
  15 => 'cognome_cliente',
  16 => 'preno_agenzia',
  17 => 'mercato',
  18 => 'conti_stato_camere',
  19 => 'acconto',
  20 => 'conto_pag_modalita',
  21 => 'conti_utente_id',
);
    private const FILTERABLE = array (
  0 => 'conto_id',
  1 => 'hotel_id',
  2 => 'foglio_id',
  3 => 'in_conto',
  4 => 'out_preno',
  5 => 'out_conto',
  6 => 'preno_id',
  7 => 'camera_id',
  8 => 'tipologia_id',
  9 => 'conti_stato_camere',
);
    private const SORTABLE = array (
  0 => 'conto_id',
  1 => 'hotel_id',
  2 => 'foglio_id',
  3 => 'in_conto',
  4 => 'out_preno',
  5 => 'out_conto',
  6 => 'preno_id',
  7 => 'camera_id',
  8 => 'tipologia_id',
  9 => 'conti_stato_camere',
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
