<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa banca_hotel secondo la configurazione del Builder. */
final class BancaHotelResource
{
    private const READABLE = array (
  0 => 'banca_hotel_id',
  1 => 'hotel_id',
  2 => 'Banca_Nome_Societa',
  3 => 'Banca_Nome',
  4 => 'Banca_via',
  5 => 'Banca_citta',
  6 => 'Intestazione',
  7 => 'BBAN',
  8 => 'CIN',
  9 => 'ABI',
  10 => 'CAB',
  11 => 'Rapporto',
  12 => 'IBAN',
  13 => 'Filiale',
  14 => 'SWIFT',
  15 => 'SWIFT_SEDE',
  16 => 'banca_utente_id',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'Banca_Nome_Societa',
  2 => 'Banca_Nome',
  3 => 'Banca_via',
  4 => 'Banca_citta',
  5 => 'Intestazione',
  6 => 'BBAN',
  7 => 'CIN',
  8 => 'ABI',
  9 => 'CAB',
  10 => 'Rapporto',
  11 => 'IBAN',
  12 => 'Filiale',
  13 => 'SWIFT',
  14 => 'SWIFT_SEDE',
  15 => 'banca_utente_id',
);
    private const FILTERABLE = array (
  0 => 'banca_hotel_id',
  1 => 'hotel_id',
);
    private const SORTABLE = array (
  0 => 'banca_hotel_id',
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
