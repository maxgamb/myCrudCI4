<?php

declare(strict_types=1);

namespace App\Validation;

final class PraticheRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'permit_empty|integer',
  'pratica_nome' => 'permit_empty|max_length[250]',
  'pratica_agenzia_id' => 'permit_empty|integer|is_not_unique[agenzie.agenzia_id]',
  'pratica_1' => 'permit_empty|max_length[50]',
  'pratica_2' => 'permit_empty|max_length[50]',
  'pratica_note' => 'permit_empty',
  'pratica_stato' => 'permit_empty|integer',
  'pratiche_utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'permit_empty|integer',
  'pratica_nome' => 'permit_empty|max_length[250]',
  'pratica_agenzia_id' => 'permit_empty|integer|is_not_unique[agenzie.agenzia_id]',
  'pratica_1' => 'permit_empty|max_length[50]',
  'pratica_2' => 'permit_empty|max_length[50]',
  'pratica_note' => 'permit_empty',
  'pratica_stato' => 'permit_empty|integer',
  'pratiche_utente_id' => 'permit_empty|integer',
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
