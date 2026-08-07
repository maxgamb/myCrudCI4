<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa hotels secondo la configurazione del Builder. */
final class HotelsResource
{
    private const READABLE = array (
  0 => 'hotel_id',
  1 => 'nome_hotel',
  2 => 'hotel_tipologia',
  3 => 'hotel_categoria',
  4 => 'hotel_citta',
  5 => 'hotel_via',
  6 => 'hotel_tel',
  7 => 'hotel_fax',
  8 => 'hotel_email',
  9 => 'hotel_stato',
  10 => 'hotel_cap',
  11 => 'hotel_piva',
  12 => 'hotel_numero_camere',
  13 => 'hotels_utente_id',
  14 => 'hotel_web',
  15 => 'hotel_logo',
  16 => 'hotel_mappa',
  17 => 'hotel_reach_by_car',
  18 => 'hotel_reach_by_treno',
  19 => 'hotel_reach_aereo',
  20 => 'hotel_reach_nave',
  21 => 'hotel_foto_piccola',
  22 => 'hotel_foto_grande',
  23 => 'hotel_testo_en',
  24 => 'hotel_testo_it',
  25 => 'hotel_disp_modo',
  26 => 'hotel_limite_vendite_web',
  27 => 'hotel_limite_vendite_xml',
  28 => 'hotel_incremento_prezzo_xml',
  29 => 'hotel_booking_attivazione',
  30 => 'hotel_booking_url',
  31 => 'hotel_booking_agenzia',
  32 => 'hotel_tarif_cambia_gg',
  33 => 'hotel_tarif_listino_nome_id',
  34 => 'hotel_agenzia_attivazione',
  35 => 'hotel_type_booking',
  36 => 'hotel_check_in',
  37 => 'hotel_check_out',
  38 => 'hotel_serv_inclusi',
  39 => 'hotel_cancel_pol',
  40 => 'facebook',
  41 => 'google',
  42 => 'instagram',
  43 => 'twitter',
  44 => 'linkedin',
  45 => 'analytics',
  46 => 'email_desk',
  47 => 'tripadvisor',
  48 => 'trip_rec_url',
  49 => 'pec',
  50 => 'sdi',
  51 => 'ae_user',
  52 => 'ae_password',
  53 => 'ae_pin',
  54 => 'ae_codice_fiscale',
  55 => 'sa_nome',
  56 => 'sa_chiave',
  57 => 'ae_test',
  58 => 'citytax',
  59 => 'wifi_network',
  60 => 'wifi_password',
  61 => 'chek_email',
  62 => 'chek_tel',
  63 => 'nexi_alias',
  64 => 'nexi_key',
  65 => 'nexi_url',
  66 => 'cir_bdsr',
  67 => 'cin_bdsr',
  68 => 'catastale_id',
);
    private const WRITABLE = array (
  0 => 'nome_hotel',
  1 => 'hotel_tipologia',
  2 => 'hotel_categoria',
  3 => 'hotel_citta',
  4 => 'hotel_via',
  5 => 'hotel_tel',
  6 => 'hotel_fax',
  7 => 'hotel_email',
  8 => 'hotel_stato',
  9 => 'hotel_cap',
  10 => 'hotel_piva',
  11 => 'hotel_numero_camere',
  12 => 'hotels_utente_id',
  13 => 'hotel_web',
  14 => 'hotel_logo',
  15 => 'hotel_mappa',
  16 => 'hotel_reach_by_car',
  17 => 'hotel_reach_by_treno',
  18 => 'hotel_reach_aereo',
  19 => 'hotel_reach_nave',
  20 => 'hotel_foto_piccola',
  21 => 'hotel_foto_grande',
  22 => 'hotel_testo_en',
  23 => 'hotel_testo_it',
  24 => 'hotel_disp_modo',
  25 => 'hotel_limite_vendite_web',
  26 => 'hotel_limite_vendite_xml',
  27 => 'hotel_incremento_prezzo_xml',
  28 => 'hotel_booking_attivazione',
  29 => 'hotel_booking_url',
  30 => 'hotel_booking_agenzia',
  31 => 'hotel_tarif_cambia_gg',
  32 => 'hotel_tarif_listino_nome_id',
  33 => 'hotel_agenzia_attivazione',
  34 => 'hotel_type_booking',
  35 => 'hotel_check_in',
  36 => 'hotel_check_out',
  37 => 'hotel_serv_inclusi',
  38 => 'hotel_cancel_pol',
  39 => 'facebook',
  40 => 'google',
  41 => 'instagram',
  42 => 'twitter',
  43 => 'linkedin',
  44 => 'analytics',
  45 => 'email_desk',
  46 => 'tripadvisor',
  47 => 'trip_rec_url',
  48 => 'pec',
  49 => 'sdi',
  50 => 'ae_user',
  51 => 'ae_password',
  52 => 'ae_pin',
  53 => 'ae_codice_fiscale',
  54 => 'sa_nome',
  55 => 'sa_chiave',
  56 => 'ae_test',
  57 => 'citytax',
  58 => 'wifi_network',
  59 => 'wifi_password',
  60 => 'chek_email',
  61 => 'chek_tel',
  62 => 'nexi_alias',
  63 => 'nexi_key',
  64 => 'nexi_url',
  65 => 'cir_bdsr',
  66 => 'cin_bdsr',
  67 => 'catastale_id',
);
    private const FILTERABLE = array (
  0 => 'hotel_id',
);
    private const SORTABLE = array (
  0 => 'hotel_id',
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
