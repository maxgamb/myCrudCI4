<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole server-side generate secondo le capability effettive del CRUD. */
final class StaffRules
{
    /** @return array<string,string> */
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
    /** @return array<string,string> */
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
    /** @return array<string,array<string,string>> */
    public static function relatedCreateRules(): array
    {
        return array (
  'address_id' =>
  array (
    'address' => 'required|max_length[50]',
    'address2' => 'permit_empty|max_length[50]',
    'district' => 'required|max_length[20]',
    'city_id' => 'required|integer|is_not_unique[city.city_id]',
    'postal_code' => 'permit_empty|max_length[10]',
    'phone' => 'required|max_length[20]',
    'location' => 'required',
  ),
  'store_id' =>
  array (
    'manager_staff_id' => 'required|integer|is_not_unique[staff.staff_id]|is_unique[store.manager_staff_id]',
    'address_id' => 'required|integer|is_not_unique[address.address_id]',
  ),
);
    }

    /** @return array<string,array<string,string>> */
    public static function manyToManyRelatedCreateRules(): array
    {
        return array (
);
    }
    /** @return array<string,string> */
    public static function messages(): array
    {
        return [];
    }
}
