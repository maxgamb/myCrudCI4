<?php

declare(strict_types=1);

namespace App\Validation;

final class ComuniRules
{
    public static function createRules(): array
    {
        return array (
  'Comuni_Codice' => 'permit_empty|max_length[250]',
  'Comuni_Nome' => 'permit_empty|max_length[250]',
  'Comuni_Prov' => 'permit_empty|max_length[250]',
  'Comuni_CAP' => 'permit_empty|max_length[250]',
  'Comuni_Prefisso' => 'permit_empty|max_length[250]',
  'Comuni_ColExcel' => 'permit_empty|max_length[250]',
  'Comuni_Nazione' => 'required|max_length[100]',
  'Comuni_Lingua' => 'required|max_length[4]',
  'nazione_iso2' => 'required|max_length[5]',
  'nazione_iso3' => 'required|max_length[5]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'Comuni_Codice' => 'permit_empty|max_length[250]',
  'Comuni_Nome' => 'permit_empty|max_length[250]',
  'Comuni_Prov' => 'permit_empty|max_length[250]',
  'Comuni_CAP' => 'permit_empty|max_length[250]',
  'Comuni_Prefisso' => 'permit_empty|max_length[250]',
  'Comuni_ColExcel' => 'permit_empty|max_length[250]',
  'Comuni_Nazione' => 'required|max_length[100]',
  'Comuni_Lingua' => 'required|max_length[4]',
  'nazione_iso2' => 'required|max_length[5]',
  'nazione_iso3' => 'required|max_length[5]',
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
