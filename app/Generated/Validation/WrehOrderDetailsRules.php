<?php

declare(strict_types=1);

namespace App\Validation;

final class WrehOrderDetailsRules
{
    public static function createRules(): array
    {
        return array (
  'order_id' => 'permit_empty|integer|is_not_unique[wreh_orders.order_id]',
  'product_id' => 'permit_empty|integer|is_not_unique[wreh_products.product_id]',
  'quantity' => 'required|integer',
  'price' => 'required|decimal',
  'utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'order_id' => 'permit_empty|integer|is_not_unique[wreh_orders.order_id]',
  'product_id' => 'permit_empty|integer|is_not_unique[wreh_products.product_id]',
  'quantity' => 'required|integer',
  'price' => 'required|decimal',
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
