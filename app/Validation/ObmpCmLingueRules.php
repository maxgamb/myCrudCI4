<?php

declare(strict_types=1);

namespace App\Validation;

final class ObmpCmLingueRules
{
    public static function createRules(): array
    {
        return array (
  'obmp_cm_rooms_id' => 'required|integer|is_not_unique[obmp_cm_rooms.obmp_cm_rooms_id]',
  'hotel_id' => 'required|integer',
  'obmp_cm_lingue_codice' => 'permit_empty|max_length[10]',
  'obmp_cm_lingue_nome' => 'permit_empty|max_length[250]',
  'obmp_cm_lingue_descrizione' => 'permit_empty|max_length[250]',
  'obmp_cm_lingue_html1' => 'permit_empty',
  'obmp_cm_lingue_html2' => 'permit_empty',
  'obmp_cm_lingue_html3' => 'permit_empty',
  'obmp_cm_lingue_note' => 'permit_empty|max_length[250]',
  'obmp_cm_lingue_politiche' => 'permit_empty|max_length[250]',
  'obmp_cm_lingue_condizioni' => 'permit_empty|max_length[250]',
  'obmp_cm_lingue_utente_id' => 'permit_empty|max_length[250]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'obmp_cm_rooms_id' => 'required|integer|is_not_unique[obmp_cm_rooms.obmp_cm_rooms_id]',
  'hotel_id' => 'required|integer',
  'obmp_cm_lingue_codice' => 'permit_empty|max_length[10]',
  'obmp_cm_lingue_nome' => 'permit_empty|max_length[250]',
  'obmp_cm_lingue_descrizione' => 'permit_empty|max_length[250]',
  'obmp_cm_lingue_html1' => 'permit_empty',
  'obmp_cm_lingue_html2' => 'permit_empty',
  'obmp_cm_lingue_html3' => 'permit_empty',
  'obmp_cm_lingue_note' => 'permit_empty|max_length[250]',
  'obmp_cm_lingue_politiche' => 'permit_empty|max_length[250]',
  'obmp_cm_lingue_condizioni' => 'permit_empty|max_length[250]',
  'obmp_cm_lingue_utente_id' => 'permit_empty|max_length[250]',
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
