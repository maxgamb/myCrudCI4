<?php

declare(strict_types=1);

namespace App\Validation;

final class EmailAiHistoryRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'required|integer',
  'raw_email' => 'required|valid_email',
  'json_classifier' => 'permit_empty',
  'category' => 'permit_empty|max_length[50]',
  'confidence' => 'permit_empty|decimal',
  'referente_tipo' => 'permit_empty|max_length[50]',
  'prenotazione_tipo' => 'permit_empty|max_length[50]',
  'finalita' => 'permit_empty|max_length[50]',
  'segmento_commerciale' => 'permit_empty|max_length[50]',
  'agent_selected' => 'permit_empty|max_length[100]',
  'reply_prompt' => 'permit_empty',
  'gpt_reply_raw' => 'permit_empty',
  'gpt_reply_clean' => 'permit_empty',
  'pms_output' => 'permit_empty',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'required|integer',
  'raw_email' => 'required|valid_email',
  'json_classifier' => 'permit_empty',
  'category' => 'permit_empty|max_length[50]',
  'confidence' => 'permit_empty|decimal',
  'referente_tipo' => 'permit_empty|max_length[50]',
  'prenotazione_tipo' => 'permit_empty|max_length[50]',
  'finalita' => 'permit_empty|max_length[50]',
  'segmento_commerciale' => 'permit_empty|max_length[50]',
  'agent_selected' => 'permit_empty|max_length[100]',
  'reply_prompt' => 'permit_empty',
  'gpt_reply_raw' => 'permit_empty',
  'gpt_reply_clean' => 'permit_empty',
  'pms_output' => 'permit_empty',
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
