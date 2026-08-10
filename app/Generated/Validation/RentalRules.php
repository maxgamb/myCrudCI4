<?php

declare(strict_types=1);

namespace App\Validation;

final class RentalRules
{
    public static function createRules(): array
    {
        return array (
  'rental_date' => 'required|valid_date',
  'inventory_id' => 'required|integer|is_not_unique[inventory.inventory_id]',
  'customer_id' => 'required|integer|is_not_unique[customer.customer_id]',
  'return_date' => 'permit_empty|valid_date',
  'staff_id' => 'required|integer|is_not_unique[staff.staff_id]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'rental_date' => 'required|valid_date',
  'inventory_id' => 'required|integer|is_not_unique[inventory.inventory_id]',
  'customer_id' => 'required|integer|is_not_unique[customer.customer_id]',
  'return_date' => 'permit_empty|valid_date',
  'staff_id' => 'required|integer|is_not_unique[staff.staff_id]',
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
  'customer_id' => 
  array (
    'store_id' => 'required|integer|is_not_unique[store.store_id]',
    'first_name' => 'required|max_length[45]',
    'last_name' => 'required|max_length[45]',
    'email' => 'permit_empty|max_length[50]|valid_email',
    'address_id' => 'required|integer|is_not_unique[address.address_id]',
    'active' => 'permit_empty|integer',
    'create_date' => 'required|valid_date',
  ),
  'inventory_id' => 
  array (
    'film_id' => 'required|integer|is_not_unique[film.film_id]',
    'store_id' => 'required|integer|is_not_unique[store.store_id]',
  ),
  'staff_id' => 
  array (
    'first_name' => 'required|max_length[45]',
    'last_name' => 'required|max_length[45]',
    'address_id' => 'required|integer|is_not_unique[address.address_id]',
    'email' => 'permit_empty|max_length[50]|valid_email',
    'store_id' => 'required|integer|is_not_unique[store.store_id]',
    'active' => 'permit_empty|integer',
    'username' => 'required|max_length[16]',
    'password' => 'permit_empty|max_length[40]',
  ),
);
    }

    public static function messages(): array
    {
        return [];
    }
}
