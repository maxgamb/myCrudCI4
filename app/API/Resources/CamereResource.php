<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa camere senza esporre campi sensibili. */
final class CamereResource
{
    private const READABLE = array (
  0 => 'camera_id',
  1 => 'hotel_id',
  2 => 'numero_camera',
  3 => 'tipologia_camera',
  4 => 'tipologia_id',
  5 => 'camere_max_pax',
  6 => 'camere_metri_quadri',
  7 => 'camere_vista',
  8 => 'camere_piano',
  9 => 'camere_bagno',
  10 => 'camere_edificio',
  11 => 'review_tot',
  12 => 'camere_data_record',
  13 => 'camere_utente_id',
  14 => 'tipologia_camera_nome_tipologia',
);
    private const WRITABLE = array (
  0 => 'camera_id',
  1 => 'hotel_id',
  2 => 'numero_camera',
  3 => 'tipologia_camera',
  4 => 'tipologia_id',
  5 => 'camere_max_pax',
  6 => 'camere_metri_quadri',
  7 => 'camere_vista',
  8 => 'camere_piano',
  9 => 'camere_bagno',
  10 => 'camere_edificio',
  11 => 'review_tot',
  12 => 'camere_data_record',
  13 => 'camere_utente_id',
);
    private const FILTERABLE = array (
  0 => 'camera_id',
  1 => 'hotel_id',
  2 => 'numero_camera',
  3 => 'tipologia_camera',
  4 => 'tipologia_id',
  5 => 'camere_max_pax',
  6 => 'camere_metri_quadri',
  7 => 'camere_vista',
  8 => 'camere_piano',
  9 => 'camere_bagno',
  10 => 'camere_edificio',
  11 => 'review_tot',
  12 => 'camere_data_record',
  13 => 'camere_utente_id',
);
    private const SORTABLE = array (
  0 => 'camera_id',
  1 => 'hotel_id',
  2 => 'numero_camera',
  3 => 'tipologia_camera',
  4 => 'tipologia_id',
  5 => 'camere_max_pax',
  6 => 'camere_metri_quadri',
  7 => 'camere_vista',
  8 => 'camere_piano',
  9 => 'camere_bagno',
  10 => 'camere_edificio',
  11 => 'review_tot',
  12 => 'camere_data_record',
  13 => 'camere_utente_id',
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
