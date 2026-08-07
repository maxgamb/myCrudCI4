<?php

declare(strict_types=1);

namespace App\Validation;

final class ObmpClientiRules
{
    public static function createRules(): array
    {
        return array (
  'obm_cliente_first_name' => 'permit_empty|max_length[250]',
  'obm_cliente_last_name' => 'permit_empty|max_length[250]',
  'obm_cliente_email' => 'permit_empty|max_length[250]|valid_email',
  'obm_cliente_city' => 'permit_empty|max_length[250]',
  'obm_cliente_country' => 'permit_empty|max_length[250]',
  'lingua' => 'permit_empty|max_length[10]',
  'obm_cliente_phone' => 'permit_empty|max_length[250]',
  'obm_cliente_newsletter' => 'permit_empty|exact_length[1]',
  'obm_cliente_pass' => 'permit_empty|max_length[250]',
  'obm_cliente_data_insert' => 'permit_empty|valid_date',
  'obm_cliente_cc_type' => 'permit_empty|max_length[10]',
  'obm_cliente_cc_number' => 'permit_empty|max_length[250]',
  'obm_cliente_holder' => 'permit_empty|max_length[250]',
  'obm_cliente_cc_expire' => 'permit_empty|max_length[10]',
  'obm_cliente_cc_security' => 'permit_empty|max_length[10]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'obm_cliente_first_name' => 'permit_empty|max_length[250]',
  'obm_cliente_last_name' => 'permit_empty|max_length[250]',
  'obm_cliente_email' => 'permit_empty|max_length[250]|valid_email',
  'obm_cliente_city' => 'permit_empty|max_length[250]',
  'obm_cliente_country' => 'permit_empty|max_length[250]',
  'lingua' => 'permit_empty|max_length[10]',
  'obm_cliente_phone' => 'permit_empty|max_length[250]',
  'obm_cliente_newsletter' => 'permit_empty|exact_length[1]',
  'obm_cliente_pass' => 'permit_empty|max_length[250]',
  'obm_cliente_data_insert' => 'permit_empty|valid_date',
  'obm_cliente_cc_type' => 'permit_empty|max_length[10]',
  'obm_cliente_cc_number' => 'permit_empty|max_length[250]',
  'obm_cliente_holder' => 'permit_empty|max_length[250]',
  'obm_cliente_cc_expire' => 'permit_empty|max_length[10]',
  'obm_cliente_cc_security' => 'permit_empty|max_length[10]',
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
