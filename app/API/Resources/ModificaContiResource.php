<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa modifica_conti secondo la configurazione del Builder. */
final class ModificaContiResource
{
    private const READABLE = array (
  0 => 'id_mod_conto',
  1 => 'mod_conto_id',
  2 => 'mod_hotel_id',
  3 => 'mod_foglio_id',
  4 => 'mod_clienti_id',
  5 => 'mod_in_conto',
  6 => 'mod_out_preno',
  7 => 'mod_out_conto',
  8 => 'mod_preno_id',
  9 => 'mod_camera_id',
  10 => 'mod_numero_camera',
  11 => 'mod_trattamento_sog',
  12 => 'mod_tipo_camera',
  13 => 'mod_prezzo',
  14 => 'mod_nome_cliente',
  15 => 'mod_cognome_cliente',
  16 => 'mod_preno_agenzia',
  17 => 'mod_mercato',
  18 => 'mod_conti_stato_camere',
  19 => 'mod_acconto',
  20 => 'modifica_conti_adebiti_utente_id',
  21 => 'conti_trattamento_sog',
);
    private const WRITABLE = array (
  0 => 'mod_conto_id',
  1 => 'mod_hotel_id',
  2 => 'mod_foglio_id',
  3 => 'mod_clienti_id',
  4 => 'mod_in_conto',
  5 => 'mod_out_preno',
  6 => 'mod_out_conto',
  7 => 'mod_preno_id',
  8 => 'mod_camera_id',
  9 => 'mod_numero_camera',
  10 => 'mod_trattamento_sog',
  11 => 'mod_tipo_camera',
  12 => 'mod_prezzo',
  13 => 'mod_nome_cliente',
  14 => 'mod_cognome_cliente',
  15 => 'mod_preno_agenzia',
  16 => 'mod_mercato',
  17 => 'mod_conti_stato_camere',
  18 => 'mod_acconto',
  19 => 'modifica_conti_adebiti_utente_id',
);
    private const FILTERABLE = array (
  0 => 'id_mod_conto',
  1 => 'mod_conto_id',
  2 => 'mod_camera_id',
);
    private const SORTABLE = array (
  0 => 'id_mod_conto',
  1 => 'mod_conto_id',
  2 => 'mod_camera_id',
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
