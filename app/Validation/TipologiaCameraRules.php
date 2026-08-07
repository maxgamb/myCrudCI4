<?php

declare(strict_types=1);

namespace App\Validation;

final class TipologiaCameraRules
{
    public static function createRules(): array
    {
        return array (
  'nome_tipologia' => 'permit_empty|max_length[100]',
  'nome_tipologia_en' => 'permit_empty|max_length[200]',
  'nome_tipologia_fr' => 'permit_empty|max_length[200]',
  'nome_tipologia_de' => 'permit_empty|max_length[200]',
  'nome_tipologia_sp' => 'permit_empty|max_length[200]',
  'nome_tipologia_jp' => 'permit_empty|max_length[200]',
  'tipologia_sigla' => 'required|max_length[10]',
  'numero_pax' => 'permit_empty|max_length[100]',
  'tipologia_camera_utente_id' => 'permit_empty|integer',
  'perc_prezzo' => 'required|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'nome_tipologia' => 'permit_empty|max_length[100]',
  'nome_tipologia_en' => 'permit_empty|max_length[200]',
  'nome_tipologia_fr' => 'permit_empty|max_length[200]',
  'nome_tipologia_de' => 'permit_empty|max_length[200]',
  'nome_tipologia_sp' => 'permit_empty|max_length[200]',
  'nome_tipologia_jp' => 'permit_empty|max_length[200]',
  'tipologia_sigla' => 'required|max_length[10]',
  'numero_pax' => 'permit_empty|max_length[100]',
  'tipologia_camera_utente_id' => 'permit_empty|integer',
  'perc_prezzo' => 'required|integer',
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
