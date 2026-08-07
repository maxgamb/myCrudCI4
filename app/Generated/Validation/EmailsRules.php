<?php

declare(strict_types=1);

namespace App\Validation;

final class EmailsRules
{
    public static function createRules(): array
    {
        return array (
  'direction' => 'permit_empty|max_length[3]',
  'uid' => 'required|max_length[255]',
  'message_id' => 'permit_empty|max_length[255]',
  'in_reply_to' => 'permit_empty|max_length[255]',
  'refs' => 'permit_empty|max_length[65535]',
  'email_from' => 'permit_empty|max_length[255]|valid_email',
  'thread_id' => 'permit_empty|max_length[100]',
  'thread_status' => 'permit_empty|max_length[6]',
  'subject' => 'permit_empty|max_length[65535]',
  'body' => 'permit_empty|max_length[65535]',
  'category' => 'permit_empty|max_length[50]',
  'language' => 'permit_empty|max_length[50]',
  'reply' => 'permit_empty|max_length[65535]',
  'attachments' => 'permit_empty|max_length[65535]',
  'replied' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'direction' => 'permit_empty|max_length[3]',
  'uid' => 'required|max_length[255]',
  'message_id' => 'permit_empty|max_length[255]',
  'in_reply_to' => 'permit_empty|max_length[255]',
  'refs' => 'permit_empty|max_length[65535]',
  'email_from' => 'permit_empty|max_length[255]|valid_email',
  'thread_id' => 'permit_empty|max_length[100]',
  'thread_status' => 'permit_empty|max_length[6]',
  'subject' => 'permit_empty|max_length[65535]',
  'body' => 'permit_empty|max_length[65535]',
  'category' => 'permit_empty|max_length[50]',
  'language' => 'permit_empty|max_length[50]',
  'reply' => 'permit_empty|max_length[65535]',
  'attachments' => 'permit_empty|max_length[65535]',
  'replied' => 'permit_empty|integer',
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
