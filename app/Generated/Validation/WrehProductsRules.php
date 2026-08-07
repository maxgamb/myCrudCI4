<?php

declare(strict_types=1);

namespace App\Validation;

final class WrehProductsRules
{
    public static function createRules(): array
    {
        return array (
  'costi_area_id' => 'required|integer|is_not_unique[costi_area.costi_area_id]',
  'name' => 'required|max_length[255]',
  'description' => 'permit_empty|max_length[65535]',
  'price' => 'required|decimal',
  'stock_quantity' => 'required|integer',
  'supplier_id' => 'permit_empty|integer|is_not_unique[wreh_suppliers.supplier_id]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'costi_area_id' => 'required|integer|is_not_unique[costi_area.costi_area_id]',
  'name' => 'required|max_length[255]',
  'description' => 'permit_empty|max_length[65535]',
  'price' => 'required|decimal',
  'stock_quantity' => 'required|integer',
  'supplier_id' => 'permit_empty|integer|is_not_unique[wreh_suppliers.supplier_id]',
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
