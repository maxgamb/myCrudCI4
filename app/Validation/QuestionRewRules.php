<?php

declare(strict_types=1);

namespace App\Validation;

final class QuestionRewRules
{
    public static function createRules(): array
    {
        return array (
  'question_id' => 'permit_empty|integer|is_not_unique[question.question_id]',
  'hotel_id' => 'permit_empty|integer',
  'conto_id' => 'permit_empty|integer',
  'clienti_id' => 'permit_empty|integer',
  'valore' => 'permit_empty|max_length[45]',
  'data' => 'permit_empty|valid_date',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'question_id' => 'permit_empty|integer|is_not_unique[question.question_id]',
  'hotel_id' => 'permit_empty|integer',
  'conto_id' => 'permit_empty|integer',
  'clienti_id' => 'permit_empty|integer',
  'valore' => 'permit_empty|max_length[45]',
  'data' => 'permit_empty|valid_date',
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
