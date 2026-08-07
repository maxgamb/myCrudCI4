<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa cassa secondo la configurazione del Builder. */
final class CassaResource
{
    private const READABLE = array (
  0 => 'cassa_id',
  1 => 'hotel_id',
  2 => 'preno_id',
  3 => 'out_conto',
  4 => 'conto_id',
  5 => 'totale_importo',
  6 => 'totale_modificato',
  7 => 'pagamento_importo_pag',
  8 => 'pagamento_forma',
  9 => 'cassa_stato_camera',
  10 => 'sospeso',
  11 => 'fattura_numero',
  12 => 'nome_pagante',
  13 => 'cassa_utente_id',
  14 => 'divisa',
  15 => 'nexi_cod_aut',
  16 => 'nexi_codTrans',
  17 => 'nexi_pan',
  18 => 'agenda_preno_arr_ore',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'preno_id',
  2 => 'out_conto',
  3 => 'conto_id',
  4 => 'totale_importo',
  5 => 'totale_modificato',
  6 => 'pagamento_importo_pag',
  7 => 'pagamento_forma',
  8 => 'cassa_stato_camera',
  9 => 'sospeso',
  10 => 'fattura_numero',
  11 => 'nome_pagante',
  12 => 'cassa_utente_id',
  13 => 'divisa',
  14 => 'nexi_cod_aut',
  15 => 'nexi_codTrans',
  16 => 'nexi_pan',
);
    private const FILTERABLE = array (
  0 => 'cassa_id',
  1 => 'hotel_id',
  2 => 'preno_id',
  3 => 'out_conto',
  4 => 'conto_id',
);
    private const SORTABLE = array (
  0 => 'cassa_id',
  1 => 'hotel_id',
  2 => 'preno_id',
  3 => 'out_conto',
  4 => 'conto_id',
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
