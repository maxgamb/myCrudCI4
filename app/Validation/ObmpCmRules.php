<?php

declare(strict_types=1);

namespace App\Validation;

final class ObmpCmRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'required|integer',
  'agenzia_id' => 'required|integer|is_not_unique[agenzie.agenzia_id]',
  'obmp_cm_id_hotel_agenzia' => 'permit_empty|max_length[200]',
  'obmp_cm_attiva' => 'permit_empty|integer',
  'obmp_cm_agenzia_url' => 'permit_empty|max_length[250]|valid_url_strict',
  'obmp_cm_agenzia_user' => 'permit_empty|max_length[250]',
  'obmp_cm_agenzia_password' => 'permit_empty|max_length[250]',
  'obmp_cm_ws_agenzia_url' => 'permit_empty|max_length[250]|valid_url_strict',
  'obmp_cm_ws_agenzia_user' => 'permit_empty|max_length[250]',
  'obmp_cm_ws_agenzia_password' => 'permit_empty|max_length[250]',
  'obmp_cm_tipologia_id1' => 'permit_empty|integer',
  'obmp_cm_room_id1' => 'permit_empty|integer',
  'obmp_cm_tipologia_id2' => 'permit_empty|integer',
  'obmp_cm_room_id2' => 'permit_empty|integer',
  'obmp_cm_tipologia_id3' => 'permit_empty|integer',
  'obmp_cm_room_id3' => 'permit_empty|integer',
  'obmp_cm_tipologia_id4' => 'permit_empty|integer',
  'obmp_cm_room_id4' => 'permit_empty|integer',
  'obmp_cm_tipologia_id5' => 'permit_empty|integer',
  'obmp_cm_room_id5' => 'permit_empty|integer',
  'obmp_cm_tipologia_id6' => 'permit_empty|integer',
  'obmp_cm_room_id6' => 'permit_empty|integer',
  'obmp_cm_tipologia_id7' => 'permit_empty|integer',
  'obmp_cm_room_id7' => 'permit_empty|integer',
  'obmp_cm_tipologia_id8' => 'permit_empty|integer',
  'obmp_cm_room_id8' => 'permit_empty|integer',
  'obmp_cm_tipologia_id9' => 'permit_empty|integer',
  'obmp_cm_room_id9' => 'permit_empty|integer',
  'obmp_cm_tipologia_id10' => 'permit_empty|integer',
  'obmp_cm_room_id10' => 'permit_empty|integer',
  'obmp_cm_moltiplicatore' => 'permit_empty|decimal',
  'obmp_cm_max_camere' => 'permit_empty|integer',
  'obmp_cm_min_camare' => 'permit_empty|integer',
  'obmp_cm_utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'required|integer',
  'agenzia_id' => 'required|integer|is_not_unique[agenzie.agenzia_id]',
  'obmp_cm_id_hotel_agenzia' => 'permit_empty|max_length[200]',
  'obmp_cm_attiva' => 'permit_empty|integer',
  'obmp_cm_agenzia_url' => 'permit_empty|max_length[250]|valid_url_strict',
  'obmp_cm_agenzia_user' => 'permit_empty|max_length[250]',
  'obmp_cm_agenzia_password' => 'permit_empty|max_length[250]',
  'obmp_cm_ws_agenzia_url' => 'permit_empty|max_length[250]|valid_url_strict',
  'obmp_cm_ws_agenzia_user' => 'permit_empty|max_length[250]',
  'obmp_cm_ws_agenzia_password' => 'permit_empty|max_length[250]',
  'obmp_cm_tipologia_id1' => 'permit_empty|integer',
  'obmp_cm_room_id1' => 'permit_empty|integer',
  'obmp_cm_tipologia_id2' => 'permit_empty|integer',
  'obmp_cm_room_id2' => 'permit_empty|integer',
  'obmp_cm_tipologia_id3' => 'permit_empty|integer',
  'obmp_cm_room_id3' => 'permit_empty|integer',
  'obmp_cm_tipologia_id4' => 'permit_empty|integer',
  'obmp_cm_room_id4' => 'permit_empty|integer',
  'obmp_cm_tipologia_id5' => 'permit_empty|integer',
  'obmp_cm_room_id5' => 'permit_empty|integer',
  'obmp_cm_tipologia_id6' => 'permit_empty|integer',
  'obmp_cm_room_id6' => 'permit_empty|integer',
  'obmp_cm_tipologia_id7' => 'permit_empty|integer',
  'obmp_cm_room_id7' => 'permit_empty|integer',
  'obmp_cm_tipologia_id8' => 'permit_empty|integer',
  'obmp_cm_room_id8' => 'permit_empty|integer',
  'obmp_cm_tipologia_id9' => 'permit_empty|integer',
  'obmp_cm_room_id9' => 'permit_empty|integer',
  'obmp_cm_tipologia_id10' => 'permit_empty|integer',
  'obmp_cm_room_id10' => 'permit_empty|integer',
  'obmp_cm_moltiplicatore' => 'permit_empty|decimal',
  'obmp_cm_max_camere' => 'permit_empty|integer',
  'obmp_cm_min_camare' => 'permit_empty|integer',
  'obmp_cm_utente_id' => 'permit_empty|integer',
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
