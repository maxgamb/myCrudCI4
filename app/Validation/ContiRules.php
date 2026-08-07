<?php

declare(strict_types=1);

namespace App\Validation;

final class ContiRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'permit_empty|integer',
  'foglio_id' => 'permit_empty|integer|is_not_unique[foglio_giorno.foglio_id]|is_unique[conti.foglio_id]',
  'clienti_id' => 'permit_empty|integer',
  'in_conto' => 'required|valid_date[Y-m-d]',
  'in_conto_time' => 'permit_empty|valid_date',
  'out_preno' => 'required|valid_date[Y-m-d]',
  'out_conto' => 'permit_empty|valid_date[Y-m-d]',
  'preno_id' => 'permit_empty|integer',
  'camera_id' => 'permit_empty|integer|is_not_unique[camere.camera_id]',
  'numero_camera' => 'permit_empty|integer',
  'trattamento_sog' => 'permit_empty|exact_length[3]',
  'tipo_camera' => 'permit_empty|max_length[100]',
  'tipologia_id' => 'permit_empty|integer',
  'prezzo' => 'required|decimal',
  'nome_cliente' => 'permit_empty|max_length[100]',
  'cognome_cliente' => 'permit_empty|max_length[100]',
  'preno_agenzia' => 'permit_empty|integer',
  'mercato' => 'permit_empty|max_length[100]',
  'conti_stato_camere' => 'required|integer',
  'acconto' => 'permit_empty|decimal',
  'conto_pag_modalita' => 'permit_empty|max_length[10]',
  'conti_utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'permit_empty|integer',
  'foglio_id' => 'permit_empty|integer|is_not_unique[foglio_giorno.foglio_id]|is_unique[conti.foglio_id,conto_id,{id}]',
  'clienti_id' => 'permit_empty|integer',
  'in_conto' => 'required|valid_date[Y-m-d]',
  'in_conto_time' => 'permit_empty|valid_date',
  'out_preno' => 'required|valid_date[Y-m-d]',
  'out_conto' => 'permit_empty|valid_date[Y-m-d]',
  'preno_id' => 'permit_empty|integer',
  'camera_id' => 'permit_empty|integer|is_not_unique[camere.camera_id]',
  'numero_camera' => 'permit_empty|integer',
  'trattamento_sog' => 'permit_empty|exact_length[3]',
  'tipo_camera' => 'permit_empty|max_length[100]',
  'tipologia_id' => 'permit_empty|integer',
  'prezzo' => 'required|decimal',
  'nome_cliente' => 'permit_empty|max_length[100]',
  'cognome_cliente' => 'permit_empty|max_length[100]',
  'preno_agenzia' => 'permit_empty|integer',
  'mercato' => 'permit_empty|max_length[100]',
  'conti_stato_camere' => 'required|integer',
  'acconto' => 'permit_empty|decimal',
  'conto_pag_modalita' => 'permit_empty|max_length[10]',
  'conti_utente_id' => 'permit_empty|integer',
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
