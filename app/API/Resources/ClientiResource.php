<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa clienti secondo la configurazione del Builder. */
final class ClientiResource
{
    private const READABLE = array (
  0 => 'clienti_id',
  1 => 'preno_id',
  2 => 'hotel_id',
  3 => 'camera_id',
  4 => 'camera_numero',
  5 => 'camara_tipologia',
  6 => 'clienti_nome',
  7 => 'clienti_cogno',
  8 => 'cliente_nato_a',
  9 => 'cliente_nato_il',
  10 => 'cliente_nazione',
  11 => 'cliente_provincia',
  12 => 'cliente_residenza',
  13 => 'cliente_cocumento_tipo',
  14 => 'cliente_cocumento_numero',
  15 => 'cliente_cocumento_rilasciato_il',
  16 => 'cliente_sesso',
  17 => 'clienti_nome1',
  18 => 'clienti_nome2',
  19 => 'clienti_nome3',
  20 => 'clienti_nome4',
  21 => 'clienti_cogno1',
  22 => 'clienti_cogno2',
  23 => 'clienti_cogno3',
  24 => 'clienti_cogno4',
  25 => 'cliente_nato_a1',
  26 => 'cliente_nato_a2',
  27 => 'cliente_nato_a3',
  28 => 'cliente_nato_a4',
  29 => 'cliente_nato_il1',
  30 => 'cliente_nato_il2',
  31 => 'cliente_nato_il3',
  32 => 'cliente_nato_il4',
  33 => 'cliente_sesso1',
  34 => 'cliente_sesso2',
  35 => 'cliente_sesso3',
  36 => 'cliente_sesso4',
  37 => 'cliente_nazione1',
  38 => 'cliente_nazione2',
  39 => 'cliente_nazione3',
  40 => 'cliente_nazione4',
  41 => 'cliente_provincia1',
  42 => 'cliente_provincia2',
  43 => 'cliente_provincia3',
  44 => 'cliente_provincia4',
  45 => 'clienti_cc_tip',
  46 => 'clienti_cc_n',
  47 => 'clienti_cc_scad',
  48 => 'clienti_tel',
  49 => 'clienti_fax',
  50 => 'clienti_email',
  51 => 'clienti_note',
  52 => 'privacy',
  53 => 'marketing',
  54 => 'lingua',
  55 => 'password',
  56 => 'clienti_utente_id',
  57 => 'refer_clienti_conto_id',
);
    private const WRITABLE = array (
  0 => 'preno_id',
  1 => 'hotel_id',
  2 => 'camera_id',
  3 => 'camera_numero',
  4 => 'camara_tipologia',
  5 => 'clienti_nome',
  6 => 'clienti_cogno',
  7 => 'cliente_nato_a',
  8 => 'cliente_nato_il',
  9 => 'cliente_nazione',
  10 => 'cliente_provincia',
  11 => 'cliente_residenza',
  12 => 'cliente_cocumento_tipo',
  13 => 'cliente_cocumento_numero',
  14 => 'cliente_cocumento_rilasciato_il',
  15 => 'cliente_sesso',
  16 => 'clienti_nome1',
  17 => 'clienti_nome2',
  18 => 'clienti_nome3',
  19 => 'clienti_nome4',
  20 => 'clienti_cogno1',
  21 => 'clienti_cogno2',
  22 => 'clienti_cogno3',
  23 => 'clienti_cogno4',
  24 => 'cliente_nato_a1',
  25 => 'cliente_nato_a2',
  26 => 'cliente_nato_a3',
  27 => 'cliente_nato_a4',
  28 => 'cliente_nato_il1',
  29 => 'cliente_nato_il2',
  30 => 'cliente_nato_il3',
  31 => 'cliente_nato_il4',
  32 => 'cliente_sesso1',
  33 => 'cliente_sesso2',
  34 => 'cliente_sesso3',
  35 => 'cliente_sesso4',
  36 => 'cliente_nazione1',
  37 => 'cliente_nazione2',
  38 => 'cliente_nazione3',
  39 => 'cliente_nazione4',
  40 => 'cliente_provincia1',
  41 => 'cliente_provincia2',
  42 => 'cliente_provincia3',
  43 => 'cliente_provincia4',
  44 => 'clienti_cc_tip',
  45 => 'clienti_cc_n',
  46 => 'clienti_cc_scad',
  47 => 'clienti_tel',
  48 => 'clienti_fax',
  49 => 'clienti_email',
  50 => 'clienti_note',
  51 => 'privacy',
  52 => 'marketing',
  53 => 'lingua',
  54 => 'password',
  55 => 'clienti_utente_id',
);
    private const FILTERABLE = array (
  0 => 'clienti_id',
  1 => 'preno_id',
  2 => 'hotel_id',
  3 => 'camera_id',
  4 => 'clienti_nome',
  5 => 'clienti_email',
);
    private const SORTABLE = array (
  0 => 'clienti_id',
  1 => 'preno_id',
  2 => 'hotel_id',
  3 => 'camera_id',
  4 => 'clienti_nome',
  5 => 'clienti_email',
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
