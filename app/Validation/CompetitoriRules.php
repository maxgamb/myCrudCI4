<?php

declare(strict_types=1);

namespace App\Validation;

final class CompetitoriRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'required|integer',
  'livello_dicompetizione' => 'required|integer',
  'competitore_nome' => 'required|max_length[250]',
  'competitore_venere_id' => 'required|integer',
  'qualita_trivago' => 'required|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'required|integer',
  'livello_dicompetizione' => 'required|integer',
  'competitore_nome' => 'required|max_length[250]',
  'competitore_venere_id' => 'required|integer',
  'qualita_trivago' => 'required|integer',
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
