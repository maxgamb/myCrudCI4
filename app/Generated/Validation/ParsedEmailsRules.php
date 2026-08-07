<?php

declare(strict_types=1);

namespace App\Validation;

final class ParsedEmailsRules
{
    public static function createRules(): array
    {
        return array (
  'id' => 'required|integer',
  'hotel_id' => 'required|integer',
  'category' => 'permit_empty|max_length[50]',
  'referente_tipo' => 'permit_empty|max_length[50]',
  'prenotazione_tipo' => 'permit_empty|max_length[50]',
  'finalita' => 'permit_empty|max_length[50]',
  'segmento_commerciale' => 'permit_empty|max_length[50]',
  'raw_email' => 'permit_empty|valid_email',
  'json_parsed' => 'permit_empty',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'id' => 'required|integer',
  'hotel_id' => 'required|integer',
  'category' => 'permit_empty|max_length[50]',
  'referente_tipo' => 'permit_empty|max_length[50]',
  'prenotazione_tipo' => 'permit_empty|max_length[50]',
  'finalita' => 'permit_empty|max_length[50]',
  'segmento_commerciale' => 'permit_empty|max_length[50]',
  'raw_email' => 'permit_empty|valid_email',
  'json_parsed' => 'permit_empty',
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
