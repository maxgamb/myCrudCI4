<?php

declare(strict_types=1);

namespace App\Validation;

final class ObmpCancellationsRules
{
    public static function createRules(): array
    {
        return array (
  'obmp_cancellation_cod' => 'required|max_length[6]',
  'obmp_cancellation_title' => 'required|max_length[100]',
  'obmp_cancellation' => 'required|max_length[255]',
  'obmp_cancellation_day' => 'required|integer',
  'cancellation_lg' => 'required|max_length[6]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'obmp_cancellation_cod' => 'required|max_length[6]',
  'obmp_cancellation_title' => 'required|max_length[100]',
  'obmp_cancellation' => 'required|max_length[255]',
  'obmp_cancellation_day' => 'required|integer',
  'cancellation_lg' => 'required|max_length[6]',
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
