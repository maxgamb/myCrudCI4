<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa sidae secondo la configurazione del Builder. */
final class SidaeResource
{
    private const READABLE = array (
  0 => 'sidae_id',
  1 => 'hotel_id',
  2 => 'conto_id',
  3 => 'foglio_id',
  4 => 'nome_cliente',
  5 => 'pag_room',
  6 => 'aliquota',
  7 => 'quan_room',
  8 => 'pag_extra',
  9 => 'extra_aliquota',
  10 => 'pag_citytax',
  11 => 'pagamentoTipo',
  12 => 'pagamentoCityTax',
  13 => 'codiceLotteria',
  14 => 'stringaLotteria',
  15 => 'se_idTrx',
  16 => 'command',
  17 => 'errore',
  18 => 'ae_idTrx',
  19 => 'numeroDocumento',
  20 => 'numeroRiferimento',
  21 => 'totaleScontrino',
  22 => 'totaleIva',
  23 => 'totaleSconto',
  24 => 'importoDetraibile',
  25 => 'data',
  26 => 'idElemento',
  27 => 'utente_id',
  28 => 'conti__conto_id__label',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'conto_id',
  2 => 'foglio_id',
  3 => 'nome_cliente',
  4 => 'pag_room',
  5 => 'aliquota',
  6 => 'quan_room',
  7 => 'pag_extra',
  8 => 'extra_aliquota',
  9 => 'pag_citytax',
  10 => 'pagamentoTipo',
  11 => 'pagamentoCityTax',
  12 => 'codiceLotteria',
  13 => 'stringaLotteria',
  14 => 'se_idTrx',
  15 => 'command',
  16 => 'errore',
  17 => 'ae_idTrx',
  18 => 'numeroDocumento',
  19 => 'numeroRiferimento',
  20 => 'totaleScontrino',
  21 => 'totaleIva',
  22 => 'totaleSconto',
  23 => 'importoDetraibile',
  24 => 'data',
  25 => 'idElemento',
  26 => 'utente_id',
);
    private const FILTERABLE = array (
  0 => 'sidae_id',
  1 => 'hotel_id',
  2 => 'conto_id',
  3 => 'numeroDocumento',
  4 => 'numeroRiferimento',
);
    private const SORTABLE = array (
  0 => 'sidae_id',
  1 => 'hotel_id',
  2 => 'conto_id',
  3 => 'numeroDocumento',
  4 => 'numeroRiferimento',
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
