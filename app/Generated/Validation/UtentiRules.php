<?php

declare(strict_types=1);

namespace App\Validation;

final class UtentiRules
{
    public static function createRules(): array
    {
        return array (
  'staff_id' => 'permit_empty|integer|is_not_unique[staff.staff_id]',
  'Nome_Utente' => 'permit_empty|max_length[50]',
  'Pass_Utente' => 'permit_empty|max_length[50]',
  'Email_Utente' => 'permit_empty|max_length[50]|valid_email',
  'hotel_id' => 'permit_empty|integer',
  'utenti_livello' => 'permit_empty|integer',
  'utenti_Utente_id' => 'required|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'staff_id' => 'permit_empty|integer|is_not_unique[staff.staff_id]',
  'Nome_Utente' => 'permit_empty|max_length[50]',
  'Pass_Utente' => 'permit_empty|max_length[50]',
  'Email_Utente' => 'permit_empty|max_length[50]|valid_email',
  'hotel_id' => 'permit_empty|integer',
  'utenti_livello' => 'permit_empty|integer',
  'utenti_Utente_id' => 'required|integer',
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
