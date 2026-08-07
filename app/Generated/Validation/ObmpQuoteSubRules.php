<?php

declare(strict_types=1);

namespace App\Validation;

final class ObmpQuoteSubRules
{
    public static function createRules(): array
    {
        return array (
  'obmp_quote_id' => 'required|integer|is_not_unique[obmp_quote.quote_id]',
  'hotel_id' => 'required|integer',
  'quote_sub_jeson' => 'required|max_length[255]',
  'quote_sub_data' => 'required|valid_date[Y-m-d]',
  'randomd_string' => 'required|max_length[100]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'obmp_quote_id' => 'required|integer|is_not_unique[obmp_quote.quote_id]',
  'hotel_id' => 'required|integer',
  'quote_sub_jeson' => 'required|max_length[255]',
  'quote_sub_data' => 'required|valid_date[Y-m-d]',
  'randomd_string' => 'required|max_length[100]',
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
