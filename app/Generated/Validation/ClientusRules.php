<?php

declare(strict_types=1);

namespace App\Validation;

final class ClientusRules
{
    public static function createRules(): array
    {
        return array (
  'preno_id' => 'permit_empty|integer',
  'hotel_id' => 'permit_empty|integer',
  'camera_id' => 'permit_empty|integer',
  'camera_numero' => 'permit_empty|integer',
  'camara_tipologia' => 'required|max_length[100]',
  'clienti_nome' => 'required|max_length[100]',
  'clienti_cogno' => 'required|max_length[100]',
  'cliente_nato_a' => 'required|max_length[100]',
  'cliente_nato_il' => 'required|max_length[12]',
  'cliente_nazione' => 'required|max_length[100]',
  'cliente_provincia' => 'permit_empty|max_length[100]',
  'cliente_residenza' => 'permit_empty|max_length[100]',
  'cliente_cocumento_tipo' => 'required|max_length[100]',
  'cliente_cocumento_numero' => 'required|max_length[100]',
  'cliente_cocumento_rilasciato_il' => 'required|max_length[12]',
  'cliente_sesso' => 'required|max_length[100]',
  'clienti_nome1' => 'permit_empty|max_length[100]',
  'clienti_nome2' => 'permit_empty|max_length[100]',
  'clienti_nome3' => 'permit_empty|max_length[100]',
  'clienti_nome4' => 'permit_empty|max_length[100]',
  'clienti_cogno1' => 'permit_empty|max_length[100]',
  'clienti_cogno2' => 'permit_empty|max_length[100]',
  'clienti_cogno3' => 'permit_empty|max_length[100]',
  'clienti_cogno4' => 'permit_empty|max_length[100]',
  'cliente_nato_a1' => 'permit_empty|max_length[100]',
  'cliente_nato_a2' => 'permit_empty|max_length[100]',
  'cliente_nato_a3' => 'permit_empty|max_length[100]',
  'cliente_nato_a4' => 'permit_empty|max_length[100]',
  'cliente_nato_il1' => 'permit_empty|max_length[12]',
  'cliente_nato_il2' => 'permit_empty|max_length[12]',
  'cliente_nato_il3' => 'permit_empty|max_length[12]',
  'cliente_nato_il4' => 'permit_empty|max_length[12]',
  'cliente_sesso1' => 'permit_empty|max_length[100]',
  'cliente_sesso2' => 'permit_empty|max_length[100]',
  'cliente_sesso3' => 'permit_empty|max_length[100]',
  'cliente_sesso4' => 'permit_empty|max_length[100]',
  'cliente_nazione1' => 'permit_empty|max_length[100]',
  'cliente_nazione2' => 'permit_empty|max_length[100]',
  'cliente_nazione3' => 'permit_empty|max_length[100]',
  'cliente_nazione4' => 'permit_empty|max_length[100]',
  'cliente_provincia1' => 'permit_empty|max_length[100]',
  'cliente_provincia2' => 'permit_empty|max_length[100]',
  'cliente_provincia3' => 'permit_empty|max_length[100]',
  'cliente_provincia4' => 'permit_empty|max_length[100]',
  'clienti_cc_tip' => 'permit_empty|max_length[100]',
  'clienti_cc_n' => 'permit_empty|max_length[100]',
  'clienti_cc_scad' => 'permit_empty|max_length[100]',
  'clienti_tel' => 'permit_empty|max_length[100]',
  'clienti_fax' => 'permit_empty|max_length[100]',
  'clienti_email' => 'permit_empty|max_length[100]|valid_email',
  'clienti_note' => 'permit_empty|max_length[100]',
  'privacy' => 'required|integer',
  'marketing' => 'required|integer',
  'lingua' => 'required|max_length[10]',
  'password' => 'permit_empty|max_length[200]',
  'clienti_utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'preno_id' => 'permit_empty|integer',
  'hotel_id' => 'permit_empty|integer',
  'camera_id' => 'permit_empty|integer',
  'camera_numero' => 'permit_empty|integer',
  'camara_tipologia' => 'required|max_length[100]',
  'clienti_nome' => 'required|max_length[100]',
  'clienti_cogno' => 'required|max_length[100]',
  'cliente_nato_a' => 'required|max_length[100]',
  'cliente_nato_il' => 'required|max_length[12]',
  'cliente_nazione' => 'required|max_length[100]',
  'cliente_provincia' => 'permit_empty|max_length[100]',
  'cliente_residenza' => 'permit_empty|max_length[100]',
  'cliente_cocumento_tipo' => 'required|max_length[100]',
  'cliente_cocumento_numero' => 'required|max_length[100]',
  'cliente_cocumento_rilasciato_il' => 'required|max_length[12]',
  'cliente_sesso' => 'required|max_length[100]',
  'clienti_nome1' => 'permit_empty|max_length[100]',
  'clienti_nome2' => 'permit_empty|max_length[100]',
  'clienti_nome3' => 'permit_empty|max_length[100]',
  'clienti_nome4' => 'permit_empty|max_length[100]',
  'clienti_cogno1' => 'permit_empty|max_length[100]',
  'clienti_cogno2' => 'permit_empty|max_length[100]',
  'clienti_cogno3' => 'permit_empty|max_length[100]',
  'clienti_cogno4' => 'permit_empty|max_length[100]',
  'cliente_nato_a1' => 'permit_empty|max_length[100]',
  'cliente_nato_a2' => 'permit_empty|max_length[100]',
  'cliente_nato_a3' => 'permit_empty|max_length[100]',
  'cliente_nato_a4' => 'permit_empty|max_length[100]',
  'cliente_nato_il1' => 'permit_empty|max_length[12]',
  'cliente_nato_il2' => 'permit_empty|max_length[12]',
  'cliente_nato_il3' => 'permit_empty|max_length[12]',
  'cliente_nato_il4' => 'permit_empty|max_length[12]',
  'cliente_sesso1' => 'permit_empty|max_length[100]',
  'cliente_sesso2' => 'permit_empty|max_length[100]',
  'cliente_sesso3' => 'permit_empty|max_length[100]',
  'cliente_sesso4' => 'permit_empty|max_length[100]',
  'cliente_nazione1' => 'permit_empty|max_length[100]',
  'cliente_nazione2' => 'permit_empty|max_length[100]',
  'cliente_nazione3' => 'permit_empty|max_length[100]',
  'cliente_nazione4' => 'permit_empty|max_length[100]',
  'cliente_provincia1' => 'permit_empty|max_length[100]',
  'cliente_provincia2' => 'permit_empty|max_length[100]',
  'cliente_provincia3' => 'permit_empty|max_length[100]',
  'cliente_provincia4' => 'permit_empty|max_length[100]',
  'clienti_cc_tip' => 'permit_empty|max_length[100]',
  'clienti_cc_n' => 'permit_empty|max_length[100]',
  'clienti_cc_scad' => 'permit_empty|max_length[100]',
  'clienti_tel' => 'permit_empty|max_length[100]',
  'clienti_fax' => 'permit_empty|max_length[100]',
  'clienti_email' => 'permit_empty|max_length[100]|valid_email',
  'clienti_note' => 'permit_empty|max_length[100]',
  'privacy' => 'required|integer',
  'marketing' => 'required|integer',
  'lingua' => 'required|max_length[10]',
  'password' => 'permit_empty|max_length[200]',
  'clienti_utente_id' => 'permit_empty|integer',
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
