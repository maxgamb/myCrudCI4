<?php

declare(strict_types=1);

namespace App\Validation;

final class CostiVarRules
{
    public static function createRules(): array
    {
        return array (
  'costi_area_id' => 'required|integer|is_not_unique[costi_area.costi_area_id]',
  'costi_var_sub_1' => 'required|max_length[45]',
  'costi_var_sub_2' => 'required|max_length[45]',
  'hotel_id' => 'required|integer',
  'costi_var_codice' => 'required|integer',
  'costi_var_nome' => 'required|max_length[250]',
  'costi_var_deposito' => 'permit_empty|decimal',
  'mag_quantita' => 'permit_empty|integer',
  'costi_var_prezzo_uso' => 'permit_empty|decimal',
  'mag_prezzo_lavaggio' => 'permit_empty|decimal',
  'costi_var_addebbito' => 'permit_empty|decimal',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'costi_area_id' => 'required|integer|is_not_unique[costi_area.costi_area_id]',
  'costi_var_sub_1' => 'required|max_length[45]',
  'costi_var_sub_2' => 'required|max_length[45]',
  'hotel_id' => 'required|integer',
  'costi_var_codice' => 'required|integer',
  'costi_var_nome' => 'required|max_length[250]',
  'costi_var_deposito' => 'permit_empty|decimal',
  'mag_quantita' => 'permit_empty|integer',
  'costi_var_prezzo_uso' => 'permit_empty|decimal',
  'mag_prezzo_lavaggio' => 'permit_empty|decimal',
  'costi_var_addebbito' => 'permit_empty|decimal',
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
