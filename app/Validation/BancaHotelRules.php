<?php

declare(strict_types=1);

namespace App\Validation;

final class BancaHotelRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'permit_empty|integer',
  'Banca_Nome_Societa' => 'required|max_length[255]',
  'Banca_Nome' => 'permit_empty|max_length[255]',
  'Banca_via' => 'permit_empty|max_length[255]',
  'Banca_citta' => 'permit_empty|max_length[255]',
  'Intestazione' => 'permit_empty|max_length[255]',
  'BBAN' => 'permit_empty|max_length[255]',
  'CIN' => 'permit_empty|max_length[255]',
  'ABI' => 'permit_empty|max_length[255]',
  'CAB' => 'permit_empty|max_length[255]',
  'Rapporto' => 'permit_empty|max_length[255]',
  'IBAN' => 'permit_empty|max_length[255]',
  'Filiale' => 'permit_empty|max_length[255]',
  'SWIFT' => 'permit_empty|max_length[255]',
  'SWIFT_SEDE' => 'permit_empty|max_length[255]',
  'banca_utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'permit_empty|integer',
  'Banca_Nome_Societa' => 'required|max_length[255]',
  'Banca_Nome' => 'permit_empty|max_length[255]',
  'Banca_via' => 'permit_empty|max_length[255]',
  'Banca_citta' => 'permit_empty|max_length[255]',
  'Intestazione' => 'permit_empty|max_length[255]',
  'BBAN' => 'permit_empty|max_length[255]',
  'CIN' => 'permit_empty|max_length[255]',
  'ABI' => 'permit_empty|max_length[255]',
  'CAB' => 'permit_empty|max_length[255]',
  'Rapporto' => 'permit_empty|max_length[255]',
  'IBAN' => 'permit_empty|max_length[255]',
  'Filiale' => 'permit_empty|max_length[255]',
  'SWIFT' => 'permit_empty|max_length[255]',
  'SWIFT_SEDE' => 'permit_empty|max_length[255]',
  'banca_utente_id' => 'permit_empty|integer',
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
