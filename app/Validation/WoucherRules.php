<?php

declare(strict_types=1);

namespace App\Validation;

final class WoucherRules
{
    public static function createRules(): array
    {
        return array (
  'woucher_agenzia_id' => 'permit_empty|integer',
  'woucher_preno_id' => 'permit_empty|integer',
  'woucher_hotel_id' => 'permit_empty|integer',
  'woucher_in' => 'required|valid_date[Y-m-d]',
  'woucher_notti' => 'permit_empty|integer',
  'woucher_out' => 'required|valid_date[Y-m-d]',
  'woucher_numero' => 'permit_empty|max_length[100]',
  'woucher_serie' => 'permit_empty|max_length[100]',
  'woucher_singole' => 'permit_empty|integer',
  'woucher_singole_staff' => 'permit_empty|integer',
  'woucher_doppia' => 'permit_empty|integer',
  'woucher_tripla' => 'permit_empty|integer',
  'woucher_quadrupla' => 'permit_empty|integer',
  'woucher_cildren_n' => 'permit_empty|integer',
  'woucher_doppia_studenti' => 'permit_empty|integer',
  'woucher_tripla_studenti' => 'permit_empty|integer',
  'woucher_quadrupla_studenti' => 'permit_empty|integer',
  'woucher_quintupla_studenti' => 'permit_empty|integer',
  'woucher_tot_pax' => 'permit_empty|integer',
  'woucher_tot_adulti' => 'permit_empty|integer',
  'woucher_tot_studenti' => 'permit_empty|integer',
  'woucher_note' => 'permit_empty',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'woucher_agenzia_id' => 'permit_empty|integer',
  'woucher_preno_id' => 'permit_empty|integer',
  'woucher_hotel_id' => 'permit_empty|integer',
  'woucher_in' => 'required|valid_date[Y-m-d]',
  'woucher_notti' => 'permit_empty|integer',
  'woucher_out' => 'required|valid_date[Y-m-d]',
  'woucher_numero' => 'permit_empty|max_length[100]',
  'woucher_serie' => 'permit_empty|max_length[100]',
  'woucher_singole' => 'permit_empty|integer',
  'woucher_singole_staff' => 'permit_empty|integer',
  'woucher_doppia' => 'permit_empty|integer',
  'woucher_tripla' => 'permit_empty|integer',
  'woucher_quadrupla' => 'permit_empty|integer',
  'woucher_cildren_n' => 'permit_empty|integer',
  'woucher_doppia_studenti' => 'permit_empty|integer',
  'woucher_tripla_studenti' => 'permit_empty|integer',
  'woucher_quadrupla_studenti' => 'permit_empty|integer',
  'woucher_quintupla_studenti' => 'permit_empty|integer',
  'woucher_tot_pax' => 'permit_empty|integer',
  'woucher_tot_adulti' => 'permit_empty|integer',
  'woucher_tot_studenti' => 'permit_empty|integer',
  'woucher_note' => 'permit_empty',
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
