<?php

declare(strict_types=1);

namespace App\Validation;

final class ObmpCmRoomsRules
{
    public static function createRules(): array
    {
        return array (
  'obmp_cm_id' => 'required|integer|is_not_unique[obmp_cm.obmp_cm_id]',
  'hotel_id' => 'required|integer',
  'obmp_cm_rooms_room_id' => 'permit_empty|integer',
  'obmp_cm_rooms_attiva' => 'permit_empty|integer',
  'obmp_cm_rooms_tipologia_id' => 'permit_empty|integer|is_not_unique[tipologia_camera.tipologia_id]',
  'obmp_cm_rooms_room_note' => 'permit_empty|max_length[200]',
  'obmp_cm_rooms_room_var_prezzo' => 'permit_empty|decimal',
  'obmp_cm_rooms_room_min_prezzo' => 'permit_empty|decimal',
  'obmp_cm_rooms_trattamento' => 'permit_empty|max_length[4]',
  'obmp_cm_rooms_max_pax' => 'permit_empty|integer',
  'obmp_cm_rooms_max_room' => 'permit_empty|integer',
  'obmp_cm_rooms_nesting' => 'required|integer',
  'citytax' => 'required|decimal',
  'obmp_cm_rooms_foto' => 'permit_empty|max_length[250]',
  'obmp_cm_rooms_foto150' => 'permit_empty|max_length[200]',
  'obmp_cm_rooms_foto270' => 'permit_empty|max_length[200]',
  'obmp_cm_rooms_foto700' => 'permit_empty|max_length[200]',
  'obmp_cm_rooms_utente_id' => 'permit_empty|max_length[200]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'obmp_cm_id' => 'required|integer|is_not_unique[obmp_cm.obmp_cm_id]',
  'hotel_id' => 'required|integer',
  'obmp_cm_rooms_room_id' => 'permit_empty|integer',
  'obmp_cm_rooms_attiva' => 'permit_empty|integer',
  'obmp_cm_rooms_tipologia_id' => 'permit_empty|integer|is_not_unique[tipologia_camera.tipologia_id]',
  'obmp_cm_rooms_room_note' => 'permit_empty|max_length[200]',
  'obmp_cm_rooms_room_var_prezzo' => 'permit_empty|decimal',
  'obmp_cm_rooms_room_min_prezzo' => 'permit_empty|decimal',
  'obmp_cm_rooms_trattamento' => 'permit_empty|max_length[4]',
  'obmp_cm_rooms_max_pax' => 'permit_empty|integer',
  'obmp_cm_rooms_max_room' => 'permit_empty|integer',
  'obmp_cm_rooms_nesting' => 'required|integer',
  'citytax' => 'required|decimal',
  'obmp_cm_rooms_foto' => 'permit_empty|max_length[250]',
  'obmp_cm_rooms_foto150' => 'permit_empty|max_length[200]',
  'obmp_cm_rooms_foto270' => 'permit_empty|max_length[200]',
  'obmp_cm_rooms_foto700' => 'permit_empty|max_length[200]',
  'obmp_cm_rooms_utente_id' => 'permit_empty|max_length[200]',
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
