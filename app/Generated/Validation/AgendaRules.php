<?php

declare(strict_types=1);

namespace App\Validation;

final class AgendaRules
{
    public static function createRules(): array
    {
        return array (
  'hotel_id' => 'permit_empty|integer',
  'preno_in_data' => 'required|valid_date',
  'preno_importo' => 'permit_empty|decimal',
  'preno_impoto_mod' => 'permit_empty|decimal',
  'preno_dal' => 'required|valid_date[Y-m-d]',
  'preno_al' => 'required|valid_date[Y-m-d]',
  'preno_n_notti' => 'permit_empty|integer',
  'preno_arr_ore' => 'permit_empty|max_length[20]',
  'preno_trattamento' => 'permit_empty|exact_length[3]',
  't1' => 'permit_empty|integer',
  'q1' => 'required|integer',
  'p1' => 'permit_empty|decimal',
  't2' => 'permit_empty|integer',
  'q2' => 'permit_empty|integer',
  'p2' => 'permit_empty|decimal',
  't3' => 'permit_empty|integer',
  'q3' => 'permit_empty|integer',
  'p3' => 'permit_empty|decimal',
  't4' => 'permit_empty|integer',
  'q4' => 'permit_empty|integer',
  'p4' => 'permit_empty|decimal',
  't5' => 'permit_empty|integer',
  'q5' => 'permit_empty|integer',
  'p5' => 'permit_empty|decimal',
  't6' => 'permit_empty|integer',
  'q6' => 'permit_empty|integer',
  'p6' => 'permit_empty|decimal',
  'preno_nome' => 'permit_empty|max_length[100]',
  'preno_cogno' => 'required|max_length[100]',
  'preno_agenzia' => 'permit_empty|integer|is_not_unique[agenzie.agenzia_id]',
  'voucher_id' => 'permit_empty|max_length[50]',
  'ota_voucher' => 'permit_empty|max_length[50]',
  'allotment_id' => 'permit_empty|integer',
  'preno_cc_tip' => 'permit_empty|max_length[100]',
  'preno_cc_n' => 'permit_empty|max_length[100]',
  'preno_cc_scad' => 'permit_empty|max_length[100]',
  'preno_tel' => 'permit_empty|max_length[100]',
  'preno_fax' => 'permit_empty|max_length[100]',
  'preno_email' => 'permit_empty|max_length[100]|valid_email',
  'preno_mercato' => 'permit_empty|max_length[100]',
  'nazione_iso2' => 'permit_empty|exact_length[5]',
  'preno_note' => 'permit_empty',
  'preno_doc_fax' => 'permit_empty|exact_length[2]',
  'preno_doc_email' => 'permit_empty|exact_length[2]|valid_email',
  'preno_doc_form' => 'permit_empty|exact_length[2]',
  'preno_doc_mail' => 'permit_empty|exact_length[2]',
  'preno_doc_vaglia' => 'permit_empty|exact_length[2]',
  'preno_doc_woucher' => 'permit_empty|exact_length[2]',
  'preno_pag_modalita' => 'permit_empty|integer',
  'preno_caparra' => 'permit_empty|decimal',
  'preno_stato' => 'required|integer',
  'data_opzione' => 'permit_empty|valid_date[Y-m-d]',
  'cancella_user' => 'permit_empty|integer',
  'cancella_pass' => 'permit_empty|max_length[100]',
  'agenda_utente_id' => 'permit_empty|integer',
);
    }

    public static function updateRules(int|string $id): array
    {
        $rules = array (
  'hotel_id' => 'permit_empty|integer',
  'preno_in_data' => 'required|valid_date',
  'preno_importo' => 'permit_empty|decimal',
  'preno_impoto_mod' => 'permit_empty|decimal',
  'preno_dal' => 'required|valid_date[Y-m-d]',
  'preno_al' => 'required|valid_date[Y-m-d]',
  'preno_n_notti' => 'permit_empty|integer',
  'preno_arr_ore' => 'permit_empty|max_length[20]',
  'preno_trattamento' => 'permit_empty|exact_length[3]',
  't1' => 'permit_empty|integer',
  'q1' => 'required|integer',
  'p1' => 'permit_empty|decimal',
  't2' => 'permit_empty|integer',
  'q2' => 'permit_empty|integer',
  'p2' => 'permit_empty|decimal',
  't3' => 'permit_empty|integer',
  'q3' => 'permit_empty|integer',
  'p3' => 'permit_empty|decimal',
  't4' => 'permit_empty|integer',
  'q4' => 'permit_empty|integer',
  'p4' => 'permit_empty|decimal',
  't5' => 'permit_empty|integer',
  'q5' => 'permit_empty|integer',
  'p5' => 'permit_empty|decimal',
  't6' => 'permit_empty|integer',
  'q6' => 'permit_empty|integer',
  'p6' => 'permit_empty|decimal',
  'preno_nome' => 'permit_empty|max_length[100]',
  'preno_cogno' => 'required|max_length[100]',
  'preno_agenzia' => 'permit_empty|integer|is_not_unique[agenzie.agenzia_id]',
  'voucher_id' => 'permit_empty|max_length[50]',
  'ota_voucher' => 'permit_empty|max_length[50]',
  'allotment_id' => 'permit_empty|integer',
  'preno_cc_tip' => 'permit_empty|max_length[100]',
  'preno_cc_n' => 'permit_empty|max_length[100]',
  'preno_cc_scad' => 'permit_empty|max_length[100]',
  'preno_tel' => 'permit_empty|max_length[100]',
  'preno_fax' => 'permit_empty|max_length[100]',
  'preno_email' => 'permit_empty|max_length[100]|valid_email',
  'preno_mercato' => 'permit_empty|max_length[100]',
  'nazione_iso2' => 'permit_empty|exact_length[5]',
  'preno_note' => 'permit_empty',
  'preno_doc_fax' => 'permit_empty|exact_length[2]',
  'preno_doc_email' => 'permit_empty|exact_length[2]|valid_email',
  'preno_doc_form' => 'permit_empty|exact_length[2]',
  'preno_doc_mail' => 'permit_empty|exact_length[2]',
  'preno_doc_vaglia' => 'permit_empty|exact_length[2]',
  'preno_doc_woucher' => 'permit_empty|exact_length[2]',
  'preno_pag_modalita' => 'permit_empty|integer',
  'preno_caparra' => 'permit_empty|decimal',
  'preno_stato' => 'required|integer',
  'data_opzione' => 'permit_empty|valid_date[Y-m-d]',
  'cancella_user' => 'permit_empty|integer',
  'cancella_pass' => 'permit_empty|max_length[100]',
  'agenda_utente_id' => 'permit_empty|integer',
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
