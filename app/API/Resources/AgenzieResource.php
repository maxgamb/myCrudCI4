<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa agenzie secondo la configurazione del Builder. */
final class AgenzieResource
{
    private const READABLE = array (
  0 => 'agenzia_id',
  1 => 'hotel_id',
  2 => 'agenzia_tipologia',
  3 => 'agenzia_nome',
  4 => 'agenzia_via',
  5 => 'agenzia_citta',
  6 => 'agenzia_state',
  7 => 'agenzia_country',
  8 => 'agenzia_cap',
  9 => 'agenzia_tel',
  10 => 'agenzia_fax',
  11 => 'agenzia_email',
  12 => 'agenzia_web',
  13 => 'agenzia_par_iva',
  14 => 'agenzia_par_cf',
  15 => 'agenzia_pec',
  16 => 'agenzia_sid',
  17 => 'agenzia_referente',
  18 => 'agenzia_banca_nome',
  19 => 'agenzia_banca_iban',
  20 => 'agenzia_banca_swift',
  21 => 'agenzia_banca_iata',
  22 => 'agenzia_cc_tipo',
  23 => 'agenzia_cc_nome',
  24 => 'agenzia_cc_numero',
  25 => 'agenzia_cc_scadenza',
  26 => 'agenzia_cc_cod_sicurezza',
  27 => 'agenzia_login',
  28 => 'agenzia_password',
  29 => 'agenzia_ab_web',
  30 => 'agenzia_ab_affiliati',
  31 => 'agenzia_ad_vis',
  32 => 'agenzia_ab_sospeso',
  33 => 'agenzie_utente_id',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'agenzia_tipologia',
  2 => 'agenzia_nome',
  3 => 'agenzia_via',
  4 => 'agenzia_citta',
  5 => 'agenzia_state',
  6 => 'agenzia_country',
  7 => 'agenzia_cap',
  8 => 'agenzia_tel',
  9 => 'agenzia_fax',
  10 => 'agenzia_email',
  11 => 'agenzia_web',
  12 => 'agenzia_par_iva',
  13 => 'agenzia_par_cf',
  14 => 'agenzia_pec',
  15 => 'agenzia_sid',
  16 => 'agenzia_referente',
  17 => 'agenzia_banca_nome',
  18 => 'agenzia_banca_iban',
  19 => 'agenzia_banca_swift',
  20 => 'agenzia_banca_iata',
  21 => 'agenzia_cc_tipo',
  22 => 'agenzia_cc_nome',
  23 => 'agenzia_cc_numero',
  24 => 'agenzia_cc_scadenza',
  25 => 'agenzia_cc_cod_sicurezza',
  26 => 'agenzia_login',
  27 => 'agenzia_password',
  28 => 'agenzia_ab_web',
  29 => 'agenzia_ab_affiliati',
  30 => 'agenzia_ad_vis',
  31 => 'agenzia_ab_sospeso',
  32 => 'agenzie_utente_id',
);
    private const FILTERABLE = array (
  0 => 'agenzia_id',
  1 => 'hotel_id',
);
    private const SORTABLE = array (
  0 => 'agenzia_id',
  1 => 'hotel_id',
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
