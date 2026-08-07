<?php

declare(strict_types=1);

namespace App\Validation;

final class ImagesRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'required|integer',
  'camera_id' => 'permit_empty|integer',
  'obmp_cm_rooms_id' => 'permit_empty|integer|is_not_unique[obmp_cm_rooms.obmp_cm_rooms_id]',
  'tipologia_id' => 'permit_empty|integer',
  'img_small' => 'permit_empty|max_length[250]',
  'img_medium' => 'permit_empty|max_length[250]',
  'img_large' => 'permit_empty|max_length[250]',
  'titolo' => 'permit_empty|max_length[250]',
  'utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'required|integer',
  'camera_id' => 'permit_empty|integer',
  'obmp_cm_rooms_id' => 'permit_empty|integer|is_not_unique[obmp_cm_rooms.obmp_cm_rooms_id]',
  'tipologia_id' => 'permit_empty|integer',
  'img_small' => 'permit_empty|max_length[250]',
  'img_medium' => 'permit_empty|max_length[250]',
  'img_large' => 'permit_empty|max_length[250]',
  'titolo' => 'permit_empty|max_length[250]',
  'utente_id' => 'permit_empty|integer',
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
