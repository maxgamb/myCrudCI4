<?php

declare(strict_types=1);

namespace App\Validation;

final class WrehSuppliersRules
{
    public static function createRules(): array
    {
        return array (
  'company' => 'required|max_length[255]',
  'contact_name' => 'permit_empty|max_length[255]',
  'phone' => 'permit_empty|max_length[50]',
  'email' => 'required|max_length[50]|valid_email',
  'address' => 'permit_empty|max_length[65535]',
  'utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'company' => 'required|max_length[255]',
  'contact_name' => 'permit_empty|max_length[255]',
  'phone' => 'permit_empty|max_length[50]',
  'email' => 'required|max_length[50]|valid_email',
  'address' => 'permit_empty|max_length[65535]',
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
