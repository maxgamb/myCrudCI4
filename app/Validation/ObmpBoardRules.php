<?php

declare(strict_types=1);

namespace App\Validation;

final class ObmpBoardRules
{
    public static function createRules(): array
    {
        return array (
  'obmp_board_id' => 'required|integer',
  'obmp_board_title' => 'required|max_length[45]|is_unique[obmp_board.obmp_board_title]',
  'obmp_board' => 'required|max_length[255]',
  'obmp_board_cod' => 'required|max_length[6]|is_unique[obmp_board.obmp_board_cod]',
  'board_lg' => 'required|max_length[4]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'obmp_board_id' => 'required|integer',
  'obmp_board_title' => 'required|max_length[45]|is_unique[obmp_board.obmp_board_title,obmp_board_id,{id}]',
  'obmp_board' => 'required|max_length[255]',
  'obmp_board_cod' => 'required|max_length[6]|is_unique[obmp_board.obmp_board_cod,obmp_board_id,{id}]',
  'board_lg' => 'required|max_length[4]',
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
