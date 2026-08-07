<?php

declare(strict_types=1);

namespace App\Validation;

final class AgenziaPrezziRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'permit_empty|integer',
  'agenzia_listini_id' => 'permit_empty|integer',
  'agenzia_listini_dal' => 'required|valid_date[Y-m-d]',
  'agenzia_listini_al' => 'required|valid_date[Y-m-d]',
  'agenzia_prezzi_1pax' => 'permit_empty|decimal',
  'agenzia_prezzi_2pax' => 'permit_empty|decimal',
  'agenzia_prezzi_3pax' => 'permit_empty|decimal',
  'agenzia_prezzi_4pax' => 'permit_empty|decimal',
  'agenzia_prezzi_free_pax' => 'permit_empty|integer',
  'agenzia_prezzi_free' => 'permit_empty|decimal',
  'agenzia_prezzi_portage' => 'permit_empty|decimal',
  'agenzia_prezzi_wdrink' => 'permit_empty|decimal',
  'agenzia_prezzi_american_bb' => 'permit_empty|decimal',
  'agenzia_prezzi_pranzo' => 'permit_empty|decimal',
  'agenzia_prezzi_cena' => 'permit_empty|decimal',
  'agenzia_prezzi_nome' => 'permit_empty|max_length[250]',
  'agenzia_prezzi_note' => 'permit_empty|max_length[250]',
  'agenzia_prezzi_datarecord' => 'permit_empty|valid_date',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'permit_empty|integer',
  'agenzia_listini_id' => 'permit_empty|integer',
  'agenzia_listini_dal' => 'required|valid_date[Y-m-d]',
  'agenzia_listini_al' => 'required|valid_date[Y-m-d]',
  'agenzia_prezzi_1pax' => 'permit_empty|decimal',
  'agenzia_prezzi_2pax' => 'permit_empty|decimal',
  'agenzia_prezzi_3pax' => 'permit_empty|decimal',
  'agenzia_prezzi_4pax' => 'permit_empty|decimal',
  'agenzia_prezzi_free_pax' => 'permit_empty|integer',
  'agenzia_prezzi_free' => 'permit_empty|decimal',
  'agenzia_prezzi_portage' => 'permit_empty|decimal',
  'agenzia_prezzi_wdrink' => 'permit_empty|decimal',
  'agenzia_prezzi_american_bb' => 'permit_empty|decimal',
  'agenzia_prezzi_pranzo' => 'permit_empty|decimal',
  'agenzia_prezzi_cena' => 'permit_empty|decimal',
  'agenzia_prezzi_nome' => 'permit_empty|max_length[250]',
  'agenzia_prezzi_note' => 'permit_empty|max_length[250]',
  'agenzia_prezzi_datarecord' => 'permit_empty|valid_date',
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
