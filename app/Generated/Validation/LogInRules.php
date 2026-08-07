<?php

declare(strict_types=1);

namespace App\Validation;

final class LogInRules
{
    public static function createRules(): array
    {
        return array (
  'log_nome' => 'permit_empty|max_length[250]',
  'log_pass' => 'permit_empty|max_length[250]',
  'log_ip' => 'permit_empty|max_length[250]',
  'log_out' => 'permit_empty|max_length[250]',
  'log_time' => 'permit_empty|valid_date',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'log_nome' => 'permit_empty|max_length[250]',
  'log_pass' => 'permit_empty|max_length[250]',
  'log_ip' => 'permit_empty|max_length[250]',
  'log_out' => 'permit_empty|max_length[250]',
  'log_time' => 'permit_empty|valid_date',
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
