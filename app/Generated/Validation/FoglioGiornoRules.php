<?php

declare(strict_types=1);

namespace App\Validation;

final class FoglioGiornoRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'required|integer',
  'conto_id' => 'permit_empty|integer',
  'camera_id' => 'required|integer|is_not_unique[camere.camera_id]',
  'preno_id' => 'permit_empty|integer|is_not_unique[agenda.preno_id]',
  'tipologia_id' => 'required|integer|is_not_unique[tipologia_camera.tipologia_id]',
  'numero_camera' => 'required|integer',
  'foglio_prezzo_camera' => 'permit_empty|decimal',
  'date_foglio' => 'permit_empty|max_length[100]',
  'nome_cliente' => 'permit_empty|max_length[100]',
  'cognome_cliente' => 'required|max_length[100]',
  'in_conto' => 'required|valid_date[Y-m-d]',
  'out_preno' => 'required|valid_date[Y-m-d]',
  'stato_camera' => 'required|integer',
  'preno_agenzia' => 'permit_empty|integer|is_not_unique[agenzie.agenzia_id]',
  'foglio_utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'required|integer',
  'conto_id' => 'permit_empty|integer',
  'camera_id' => 'required|integer|is_not_unique[camere.camera_id]',
  'preno_id' => 'permit_empty|integer|is_not_unique[agenda.preno_id]',
  'tipologia_id' => 'required|integer|is_not_unique[tipologia_camera.tipologia_id]',
  'numero_camera' => 'required|integer',
  'foglio_prezzo_camera' => 'permit_empty|decimal',
  'date_foglio' => 'permit_empty|max_length[100]',
  'nome_cliente' => 'permit_empty|max_length[100]',
  'cognome_cliente' => 'required|max_length[100]',
  'in_conto' => 'required|valid_date[Y-m-d]',
  'out_preno' => 'required|valid_date[Y-m-d]',
  'stato_camera' => 'required|integer',
  'preno_agenzia' => 'permit_empty|integer|is_not_unique[agenzie.agenzia_id]',
  'foglio_utente_id' => 'permit_empty|integer',
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
