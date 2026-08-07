<?php

declare(strict_types=1);

namespace App\Validation;

final class TipDocRules
{
    public static function createRules(): array
    {
        return array (
  'Doc_CodMin' => 'permit_empty|max_length[30]|is_unique[tip_doc.Doc_CodMin]',
  'Doc_Descrizione' => 'permit_empty|max_length[250]|is_unique[tip_doc.Doc_Descrizione]',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'Doc_CodMin' => 'permit_empty|max_length[30]|is_unique[tip_doc.Doc_CodMin,tip_doc_id,{id}]',
  'Doc_Descrizione' => 'permit_empty|max_length[250]|is_unique[tip_doc.Doc_Descrizione,tip_doc_id,{id}]',
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
