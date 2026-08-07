<?php

declare(strict_types=1);

namespace App\Validation;

final class ProdottiListaRules
{
    public static function createRules(): array
    {
        return array (
  'prod_lista_mone' => 'required|max_length[100]',
  'prod_lista_descrixione' => 'permit_empty|max_length[250]',
  'prod_lista_allergenici' => 'permit_empty|max_length[250]',
  'prod_lista_costo_unitario' => 'permit_empty|decimal',
  'prod_lista_img' => 'permit_empty|max_length[100]',
  'prod_lista_data' => 'permit_empty|valid_date[Y-m-d]',
  'prod_lista_user_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'prod_lista_mone' => 'required|max_length[100]',
  'prod_lista_descrixione' => 'permit_empty|max_length[250]',
  'prod_lista_allergenici' => 'permit_empty|max_length[250]',
  'prod_lista_costo_unitario' => 'permit_empty|decimal',
  'prod_lista_img' => 'permit_empty|max_length[100]',
  'prod_lista_data' => 'permit_empty|valid_date[Y-m-d]',
  'prod_lista_user_id' => 'permit_empty|integer',
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
