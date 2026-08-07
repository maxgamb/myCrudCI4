<?php

declare(strict_types=1);

namespace App\Validation;

final class ProductsRules
{
    public static function createRules(): array
    {
        return array (
  'name' => 'required|max_length[255]',
  'description' => 'permit_empty|max_length[65535]',
  'price' => 'required|decimal',
  'stock_quantity' => 'required|integer',
  'supplier_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'name' => 'required|max_length[255]',
  'description' => 'permit_empty|max_length[65535]',
  'price' => 'required|decimal',
  'stock_quantity' => 'required|integer',
  'supplier_id' => 'permit_empty|integer',
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
