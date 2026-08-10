<?php

declare(strict_types=1);

namespace App\Validation;

final class StaffRules
{
    public static function createRules(): array
    {
        return array (
  'first_name' => 'required|max_length[45]',
  'last_name' => 'required|max_length[45]',
  'address_id' => 'required|integer|is_not_unique[address.address_id]',
  'picture' => 'permit_empty|max_length[65535]',
  'email' => 'permit_empty|max_length[50]|valid_email',
  'store_id' => 'required|integer|is_not_unique[store.store_id]',
  'active' => 'required|integer',
  'username' => 'required|max_length[16]',
  'password' => 'permit_empty|max_length[40]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'first_name' => 'required|max_length[45]',
  'last_name' => 'required|max_length[45]',
  'address_id' => 'required|integer|is_not_unique[address.address_id]',
  'picture' => 'permit_empty|max_length[65535]',
  'email' => 'permit_empty|max_length[50]|valid_email',
  'store_id' => 'required|integer|is_not_unique[store.store_id]',
  'active' => 'required|integer',
  'username' => 'required|max_length[16]',
  'password' => 'permit_empty|max_length[40]',
);
        foreach ($rules as $field => $rule) {
            $rules[$field] = str_replace('{id}', (string) $id, $rule);
        }
        return $rules;
    }

    /** Regole dei record padre creati nello stesso submit. */
    public static function relatedCreateRules(): array
    {
        return array (
  'store_id' => 
  array (
    'manager_staff_id' => 'required|integer|is_not_unique[staff.staff_id]|is_unique[store.manager_staff_id]',
    'address_id' => 'required|integer|is_not_unique[address.address_id]',
  ),
);
    }

    public static function messages(): array
    {
        return [];
    }
}
