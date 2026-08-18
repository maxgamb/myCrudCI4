<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole server-side generate secondo le capability effettive del CRUD. */
final class PaymentRules
{
    /** @return array<string,string> */
    public static function createRules(): array
    {
        return array (
  'customer_id' => 'required|integer|is_not_unique[customer.customer_id]',
  'staff_id' => 'required|integer|is_not_unique[staff.staff_id]',
  'rental_id' => 'permit_empty|integer|is_not_unique[rental.rental_id]',
  'amount' => 'required|decimal',
  'payment_date' => 'required|valid_date',
);
    }
    /** @return array<string,string> */
    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'customer_id' => 'required|integer|is_not_unique[customer.customer_id]',
  'staff_id' => 'required|integer|is_not_unique[staff.staff_id]',
  'rental_id' => 'permit_empty|integer|is_not_unique[rental.rental_id]',
  'amount' => 'required|decimal',
  'payment_date' => 'required|valid_date',
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
  'rental_id' =>
  array (
    'rental_date' => 'required|valid_date',
    'inventory_id' => 'required|integer|is_not_unique[inventory.inventory_id]',
    'customer_id' => 'required|integer|is_not_unique[customer.customer_id]',
    'return_date' => 'permit_empty|valid_date',
    'staff_id' => 'required|integer|is_not_unique[staff.staff_id]',
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
