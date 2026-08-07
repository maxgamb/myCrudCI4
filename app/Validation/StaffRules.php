<?php

declare(strict_types=1);

namespace App\Validation;

final class StaffRules
{
    public static function createRules(): array
    {
        return array (
  'cognome' => 'required|max_length[200]',
  'nome' => 'required|max_length[200]',
  'citta' => 'required|max_length[200]',
  'provincia' => 'required|max_length[100]',
  'staff_nazione' => 'required|max_length[50]',
  'indirizzo' => 'required|max_length[200]',
  'telefono' => 'required|max_length[40]',
  'cellulare' => 'required|max_length[40]',
  'email' => 'required|max_length[40]|valid_email',
  'genere' => 'required|max_length[2]',
  'reparto_id' => 'required|max_length[20]',
  'staff_stato' => 'required|integer',
  'staff_datarecod' => 'permit_empty|valid_date',
  'utente_id' => 'required|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'cognome' => 'required|max_length[200]',
  'nome' => 'required|max_length[200]',
  'citta' => 'required|max_length[200]',
  'provincia' => 'required|max_length[100]',
  'staff_nazione' => 'required|max_length[50]',
  'indirizzo' => 'required|max_length[200]',
  'telefono' => 'required|max_length[40]',
  'cellulare' => 'required|max_length[40]',
  'email' => 'required|max_length[40]|valid_email',
  'genere' => 'required|max_length[2]',
  'reparto_id' => 'required|max_length[20]',
  'staff_stato' => 'required|integer',
  'staff_datarecod' => 'permit_empty|valid_date',
  'utente_id' => 'required|integer',
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
