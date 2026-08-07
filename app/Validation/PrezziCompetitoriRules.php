<?php

declare(strict_types=1);

namespace App\Validation;

final class PrezziCompetitoriRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'required|integer',
  'data_prezzo' => 'required|valid_date[Y-m-d]',
  'percentile_10' => 'permit_empty|decimal',
  'percentile_25' => 'permit_empty|decimal',
  'percentile_50' => 'permit_empty|decimal',
  'percentile_75' => 'permit_empty|decimal',
  'percentile_90' => 'permit_empty|decimal',
  'indice_disponibilita' => 'permit_empty|decimal',
  'data_acuisizione' => 'required|valid_date[Y-m-d]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'required|integer',
  'data_prezzo' => 'required|valid_date[Y-m-d]',
  'percentile_10' => 'permit_empty|decimal',
  'percentile_25' => 'permit_empty|decimal',
  'percentile_50' => 'permit_empty|decimal',
  'percentile_75' => 'permit_empty|decimal',
  'percentile_90' => 'permit_empty|decimal',
  'indice_disponibilita' => 'permit_empty|decimal',
  'data_acuisizione' => 'required|valid_date[Y-m-d]',
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
