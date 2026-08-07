<?php

declare(strict_types=1);

namespace App\Validation;

final class ColoriRules
{
    public static function createRules(): array
    {
        return array (
  'colore_nome' => 'permit_empty|max_length[10]',
  'colore_codice' => 'permit_empty|max_length[10]',
  'col_preno_id' => 'permit_empty|integer|is_not_unique[agenda.preno_id]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'colore_nome' => 'permit_empty|max_length[10]',
  'colore_codice' => 'permit_empty|max_length[10]',
  'col_preno_id' => 'permit_empty|integer|is_not_unique[agenda.preno_id]',
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
