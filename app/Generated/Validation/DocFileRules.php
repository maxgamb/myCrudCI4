<?php

declare(strict_types=1);

namespace App\Validation;

final class DocFileRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'required|integer|is_not_unique[hotels.hotel_id]',
  'doc_dipar_id' => 'required|integer',
  'doc_protocollo' => 'required|integer',
  'doc_url_file' => 'required|max_length[255]|valid_url_strict',
  'doc_note' => 'permit_empty|max_length[255]',
  'doc_utente_id' => 'required|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'required|integer|is_not_unique[hotels.hotel_id]',
  'doc_dipar_id' => 'required|integer',
  'doc_protocollo' => 'required|integer',
  'doc_url_file' => 'required|max_length[255]|valid_url_strict',
  'doc_note' => 'permit_empty|max_length[255]',
  'doc_utente_id' => 'required|integer',
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
