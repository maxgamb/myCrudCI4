<?php

declare(strict_types=1);

namespace App\Validation;

final class SidaeRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'required|integer',
  'conto_id' => 'required|integer|is_not_unique[conti.conto_id]',
  'foglio_id' => 'required|integer',
  'nome_cliente' => 'required|max_length[250]',
  'pag_room' => 'required|decimal',
  'aliquota' => 'required|decimal',
  'quan_room' => 'required|integer',
  'pag_extra' => 'required|decimal',
  'extra_aliquota' => 'required|integer',
  'pag_citytax' => 'required|decimal',
  'pagamentoTipo' => 'required|max_length[50]',
  'pagamentoCityTax' => 'required|max_length[50]',
  'codiceLotteria' => 'required|max_length[200]',
  'stringaLotteria' => 'required|max_length[200]',
  'se_idTrx' => 'required|integer',
  'command' => 'required|max_length[100]',
  'errore' => 'required|max_length[225]',
  'ae_idTrx' => 'required|integer',
  'numeroDocumento' => 'required|max_length[250]',
  'numeroRiferimento' => 'required|max_length[250]',
  'totaleScontrino' => 'required|decimal',
  'totaleIva' => 'required|decimal',
  'totaleSconto' => 'required|decimal',
  'importoDetraibile' => 'required|decimal',
  'data' => 'required|valid_date',
  'idElemento' => 'required|max_length[250]',
  'utente_id' => 'required|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'required|integer',
  'conto_id' => 'required|integer|is_not_unique[conti.conto_id]',
  'foglio_id' => 'required|integer',
  'nome_cliente' => 'required|max_length[250]',
  'pag_room' => 'required|decimal',
  'aliquota' => 'required|decimal',
  'quan_room' => 'required|integer',
  'pag_extra' => 'required|decimal',
  'extra_aliquota' => 'required|integer',
  'pag_citytax' => 'required|decimal',
  'pagamentoTipo' => 'required|max_length[50]',
  'pagamentoCityTax' => 'required|max_length[50]',
  'codiceLotteria' => 'required|max_length[200]',
  'stringaLotteria' => 'required|max_length[200]',
  'se_idTrx' => 'required|integer',
  'command' => 'required|max_length[100]',
  'errore' => 'required|max_length[225]',
  'ae_idTrx' => 'required|integer',
  'numeroDocumento' => 'required|max_length[250]',
  'numeroRiferimento' => 'required|max_length[250]',
  'totaleScontrino' => 'required|decimal',
  'totaleIva' => 'required|decimal',
  'totaleSconto' => 'required|decimal',
  'importoDetraibile' => 'required|decimal',
  'data' => 'required|valid_date',
  'idElemento' => 'required|max_length[250]',
  'utente_id' => 'required|integer',
);
        foreach ($rules as $field => $rule) {
            $rules[$field] = str_replace('{id}', (string) $id, $rule);
        }
        return $rules;
    }

    public static function messages(): array
    {
        return [];
    }
}
