<?php

declare(strict_types=1);

namespace App\Validation;

final class NazioniRules
{
    public static function createRules(): array
    {
        return array (
  'Nazioni_Id_Codice' => 'permit_empty|max_length[30]',
  'Nazioni_Codice' => 'permit_empty|max_length[30]',
  'Nazioni_Descrizione' => 'permit_empty|max_length[250]',
  'Nazioni_Targa' => 'permit_empty|max_length[30]',
  'Nazioni_ColExcel' => 'permit_empty|max_length[30]',
  'EN_Country' => 'permit_empty|max_length[250]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'Nazioni_Id_Codice' => 'permit_empty|max_length[30]',
  'Nazioni_Codice' => 'permit_empty|max_length[30]',
  'Nazioni_Descrizione' => 'permit_empty|max_length[250]',
  'Nazioni_Targa' => 'permit_empty|max_length[30]',
  'Nazioni_ColExcel' => 'permit_empty|max_length[30]',
  'EN_Country' => 'permit_empty|max_length[250]',
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
