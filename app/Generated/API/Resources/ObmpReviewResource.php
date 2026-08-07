<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa obmp_review secondo la configurazione del Builder. */
final class ObmpReviewResource
{
    private const READABLE = array (
  0 => 'review_id',
  1 => 'hotel_id',
  2 => 'preno_id',
  3 => 'conto_id',
  4 => 'postazione_id',
  5 => 'camera_numero',
  6 => 'nome',
  7 => 'stato',
  8 => 'user_type',
  9 => 'pulizia_camera',
  10 => 'accoglienza',
  11 => 'rumore_camere',
  12 => 'spazio_camera',
  13 => 'spazi_comuni',
  14 => 'competenza_impiegati',
  15 => 'qualita_servizi',
  16 => 'dintorni',
  17 => 'colazione',
  18 => 'tariffa',
  19 => 'servizi_offerti',
  20 => 'foto',
  21 => 'indicazione_mappa',
  22 => 'giudizio_totale',
  23 => 'prezzo_qualita',
  24 => 'commento_tex',
  25 => 'risposta',
  26 => 'raccomandi',
  27 => 'ip_review',
  28 => 'data_review',
  29 => 'conti_trattamento_sog',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'preno_id',
  2 => 'conto_id',
  3 => 'postazione_id',
  4 => 'camera_numero',
  5 => 'nome',
  6 => 'stato',
  7 => 'user_type',
  8 => 'pulizia_camera',
  9 => 'accoglienza',
  10 => 'rumore_camere',
  11 => 'spazio_camera',
  12 => 'spazi_comuni',
  13 => 'competenza_impiegati',
  14 => 'qualita_servizi',
  15 => 'dintorni',
  16 => 'colazione',
  17 => 'tariffa',
  18 => 'servizi_offerti',
  19 => 'foto',
  20 => 'indicazione_mappa',
  21 => 'giudizio_totale',
  22 => 'prezzo_qualita',
  23 => 'commento_tex',
  24 => 'risposta',
  25 => 'raccomandi',
  26 => 'ip_review',
  27 => 'data_review',
);
    private const FILTERABLE = array (
  0 => 'review_id',
  1 => 'hotel_id',
  2 => 'preno_id',
  3 => 'conto_id',
  4 => 'postazione_id',
);
    private const SORTABLE = array (
  0 => 'review_id',
  1 => 'hotel_id',
  2 => 'preno_id',
  3 => 'conto_id',
  4 => 'postazione_id',
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
