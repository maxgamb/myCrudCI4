<?php

declare(strict_types=1);

namespace App\Validation;

final class QuestionRules
{
    public static function createRules(): array
    {
        return array (
  'title' => 'permit_empty|max_length[240]',
  'tex_lingue_id_pro' => 'permit_empty|integer',
  'tex_lingue_id_con' => 'permit_empty|integer',
  'tex_pro' => 'required|max_length[200]',
  'tex_no' => 'required|max_length[200]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'title' => 'permit_empty|max_length[240]',
  'tex_lingue_id_pro' => 'permit_empty|integer',
  'tex_lingue_id_con' => 'permit_empty|integer',
  'tex_pro' => 'required|max_length[200]',
  'tex_no' => 'required|max_length[200]',
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
