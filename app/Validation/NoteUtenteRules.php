<?php

declare(strict_types=1);

namespace App\Validation;

final class NoteUtenteRules
{
    public static function createRules(): array
    {
        return array (
  'note_utente_rispondi_id' => 'permit_empty|integer',
  'Utente_id' => 'required|integer|is_not_unique[utenti.Utente_id]',
  'hotel_id' => 'required|integer',
  'reparto' => 'required|integer',
  'titolo' => 'permit_empty|max_length[250]',
  'note_utente_tex' => 'required',
  'note_utente_per' => 'required|integer',
  'note_utente_stato' => 'required|integer',
  'note_utente_dal' => 'required|valid_date[Y-m-d]',
  'note_utente_al' => 'required|valid_date[Y-m-d]',
  'note_utente_data' => 'required|valid_date[Y-m-d]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'note_utente_rispondi_id' => 'permit_empty|integer',
  'Utente_id' => 'required|integer|is_not_unique[utenti.Utente_id]',
  'hotel_id' => 'required|integer',
  'reparto' => 'required|integer',
  'titolo' => 'permit_empty|max_length[250]',
  'note_utente_tex' => 'required',
  'note_utente_per' => 'required|integer',
  'note_utente_stato' => 'required|integer',
  'note_utente_dal' => 'required|valid_date[Y-m-d]',
  'note_utente_al' => 'required|valid_date[Y-m-d]',
  'note_utente_data' => 'required|valid_date[Y-m-d]',
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
