<?php

namespace App\Models;

use CodeIgniter\Model;

class AgendaModel extends Model
{
    protected $table            = 'agenda';
    protected $primaryKey       = 'preno_id';
    protected $returnType       = 'object';
    protected $useSoftDeletes = false;
    protected $protectFields    = true;
    protected $allowedFields    = array (
  0 => 'hotel_id',
  1 => 'preno_in_data',
  2 => 'preno_importo',
  3 => 'preno_impoto_mod',
  4 => 'preno_dal',
  5 => 'preno_al',
  6 => 'preno_n_notti',
  7 => 'preno_arr_ore',
  8 => 'preno_trattamento',
  9 => 't1',
  10 => 'q1',
  11 => 'p1',
  12 => 't2',
  13 => 'q2',
  14 => 'p2',
  15 => 't3',
  16 => 'q3',
  17 => 'p3',
  18 => 't4',
  19 => 'q4',
  20 => 'p4',
  21 => 't5',
  22 => 'q5',
  23 => 'p5',
  24 => 't6',
  25 => 'q6',
  26 => 'p6',
  27 => 'preno_nome',
  28 => 'preno_cogno',
  29 => 'preno_agenzia',
  30 => 'voucher_id',
  31 => 'ota_voucher',
  32 => 'allotment_id',
  33 => 'preno_cc_tip',
  34 => 'preno_cc_n',
  35 => 'preno_cc_scad',
  36 => 'preno_tel',
  37 => 'preno_fax',
  38 => 'preno_email',
  39 => 'preno_mercato',
  40 => 'nazione_iso2',
  41 => 'preno_note',
  42 => 'preno_doc_fax',
  43 => 'preno_doc_email',
  44 => 'preno_doc_form',
  45 => 'preno_doc_mail',
  46 => 'preno_doc_vaglia',
  47 => 'preno_doc_woucher',
  48 => 'preno_pag_modalita',
  49 => 'preno_caparra',
  50 => 'preno_stato',
  51 => 'data_opzione',
  52 => 'cancella_data_record',
  53 => 'cancella_user',
  54 => 'cancella_pass',
  55 => 'preno_data_record',
  56 => 'agenda_utente_id',
);
    protected $useTimestamps    = false;
    protected $skipValidation   = true;
    protected $cleanValidationRules = true;

    /**
     * Elenco standard a oggetti.
     *
     * Basic: stdClass.
     * Standard/Full: Entity quando non ci sono JOIN.
     * Con JOIN questo metodo restituisce stdClass per preservare gli alias.
     *
     * @return list<object>
     */
    public function getList(array $filters = []): array
    {
        $builder = $this->builder();
        $builder->select([
            'agenda.*',
            'agenzie.hotel_id AS agenzie_hotel_id'
        ]);

        $builder->join('agenzie', 'agenzie.agenzia_id = agenda.preno_agenzia', 'left');

        foreach ($filters as $field => $value) {
            if ($value === null || $value === '') {
                continue;
            }

            if (in_array($field, $this->allowedFields, true) || $field === $this->primaryKey) {
                $builder->where("agenda." . $field, $value);
            }
        }

        return $builder
            ->orderBy("agenda.preno_id", 'DESC')
            ->get()
            ->getResult();
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->builder()
            ->where($this->primaryKey, $id)
            ->get()
            ->getRow($this->returnType);
    }

    /**
     * Query base per DataTables.
     */
    public function datatableBuilder(): \CodeIgniter\Database\BaseBuilder
    {
        $builder = $this->builder();
        $builder->select([
            'agenda.*',
            'agenzie.hotel_id AS agenzie_hotel_id'
        ]);

        $builder->join('agenzie', 'agenzie.agenzia_id = agenda.preno_agenzia', 'left');

        return $builder;
    }
}
