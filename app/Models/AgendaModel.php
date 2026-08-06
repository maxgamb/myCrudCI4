<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\AgendaEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per agenda; tutte le query del CRUD sono centralizzate qui. */
final class AgendaModel extends Model
{
    protected $table = 'agenda';
    protected $primaryKey = 'preno_id';
    protected $returnType = AgendaEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
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
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
  'preno_id' => 
  array (
    'mode' => 'exact',
    'type' => 'int',
  ),
  'hotel_id' => 
  array (
    'mode' => 'exact',
    'type' => 'int',
  ),
  'preno_in_data' => 
  array (
    'mode' => 'range',
    'type' => 'datetime',
  ),
  'preno_importo' => 
  array (
    'mode' => 'exact',
    'type' => 'decimal',
  ),
  'preno_impoto_mod' => 
  array (
    'mode' => 'exact',
    'type' => 'decimal',
  ),
  'preno_dal' => 
  array (
    'mode' => 'range',
    'type' => 'date',
  ),
  'preno_al' => 
  array (
    'mode' => 'range',
    'type' => 'date',
  ),
  'preno_n_notti' => 
  array (
    'mode' => 'exact',
    'type' => 'smallint',
  ),
  'preno_arr_ore' => 
  array (
    'mode' => 'prefix',
    'type' => 'varchar',
  ),
  'preno_trattamento' => 
  array (
    'mode' => 'prefix',
    'type' => 'char',
  ),
  't1' => 
  array (
    'mode' => 'exact',
    'type' => 'smallint',
  ),
  'q1' => 
  array (
    'mode' => 'exact',
    'type' => 'smallint',
  ),
  'p1' => 
  array (
    'mode' => 'exact',
    'type' => 'decimal',
  ),
  't2' => 
  array (
    'mode' => 'exact',
    'type' => 'smallint',
  ),
  'q2' => 
  array (
    'mode' => 'exact',
    'type' => 'smallint',
  ),
  'p2' => 
  array (
    'mode' => 'exact',
    'type' => 'decimal',
  ),
  't3' => 
  array (
    'mode' => 'exact',
    'type' => 'smallint',
  ),
  'q3' => 
  array (
    'mode' => 'exact',
    'type' => 'smallint',
  ),
  'p3' => 
  array (
    'mode' => 'exact',
    'type' => 'decimal',
  ),
  't4' => 
  array (
    'mode' => 'exact',
    'type' => 'smallint',
  ),
  'q4' => 
  array (
    'mode' => 'exact',
    'type' => 'smallint',
  ),
  'p4' => 
  array (
    'mode' => 'exact',
    'type' => 'decimal',
  ),
  't5' => 
  array (
    'mode' => 'exact',
    'type' => 'smallint',
  ),
  'q5' => 
  array (
    'mode' => 'exact',
    'type' => 'smallint',
  ),
  'p5' => 
  array (
    'mode' => 'exact',
    'type' => 'decimal',
  ),
  't6' => 
  array (
    'mode' => 'exact',
    'type' => 'smallint',
  ),
  'q6' => 
  array (
    'mode' => 'exact',
    'type' => 'smallint',
  ),
  'p6' => 
  array (
    'mode' => 'exact',
    'type' => 'decimal',
  ),
  'preno_nome' => 
  array (
    'mode' => 'prefix',
    'type' => 'varchar',
  ),
  'preno_cogno' => 
  array (
    'mode' => 'prefix',
    'type' => 'varchar',
  ),
  'preno_agenzia' => 
  array (
    'mode' => 'exact',
    'type' => 'int',
  ),
  'voucher_id' => 
  array (
    'mode' => 'prefix',
    'type' => 'varchar',
  ),
  'ota_voucher' => 
  array (
    'mode' => 'prefix',
    'type' => 'varchar',
  ),
  'allotment_id' => 
  array (
    'mode' => 'exact',
    'type' => 'int',
  ),
  'preno_cc_tip' => 
  array (
    'mode' => 'prefix',
    'type' => 'varchar',
  ),
  'preno_cc_n' => 
  array (
    'mode' => 'prefix',
    'type' => 'varchar',
  ),
  'preno_cc_scad' => 
  array (
    'mode' => 'prefix',
    'type' => 'varchar',
  ),
  'preno_tel' => 
  array (
    'mode' => 'prefix',
    'type' => 'varchar',
  ),
  'preno_fax' => 
  array (
    'mode' => 'prefix',
    'type' => 'varchar',
  ),
  'preno_email' => 
  array (
    'mode' => 'prefix',
    'type' => 'varchar',
  ),
  'preno_mercato' => 
  array (
    'mode' => 'prefix',
    'type' => 'varchar',
  ),
  'nazione_iso2' => 
  array (
    'mode' => 'prefix',
    'type' => 'char',
  ),
  'preno_doc_fax' => 
  array (
    'mode' => 'prefix',
    'type' => 'char',
  ),
  'preno_doc_email' => 
  array (
    'mode' => 'prefix',
    'type' => 'char',
  ),
  'preno_doc_form' => 
  array (
    'mode' => 'prefix',
    'type' => 'char',
  ),
  'preno_doc_mail' => 
  array (
    'mode' => 'prefix',
    'type' => 'char',
  ),
  'preno_doc_vaglia' => 
  array (
    'mode' => 'prefix',
    'type' => 'char',
  ),
  'preno_doc_woucher' => 
  array (
    'mode' => 'prefix',
    'type' => 'char',
  ),
  'preno_pag_modalita' => 
  array (
    'mode' => 'exact',
    'type' => 'smallint',
  ),
  'preno_caparra' => 
  array (
    'mode' => 'exact',
    'type' => 'decimal',
  ),
  'preno_stato' => 
  array (
    'mode' => 'exact',
    'type' => 'smallint',
  ),
  'data_opzione' => 
  array (
    'mode' => 'range',
    'type' => 'date',
  ),
  'cancella_data_record' => 
  array (
    'mode' => 'range',
    'type' => 'datetime',
  ),
);
    private const SORTABLE_FIELDS = array (
  0 => 'preno_id',
  1 => 'hotel_id',
  2 => 'preno_in_data',
  3 => 'preno_importo',
  4 => 'preno_impoto_mod',
  5 => 'preno_dal',
  6 => 'preno_al',
  7 => 'preno_n_notti',
  8 => 'preno_arr_ore',
  9 => 'preno_trattamento',
  10 => 't1',
  11 => 'q1',
  12 => 'p1',
  13 => 't2',
  14 => 'q2',
  15 => 'p2',
  16 => 't3',
  17 => 'q3',
  18 => 'p3',
  19 => 't4',
  20 => 'q4',
  21 => 'p4',
  22 => 't5',
  23 => 'q5',
  24 => 'p5',
  25 => 't6',
  26 => 'q6',
  27 => 'p6',
  28 => 'preno_nome',
  29 => 'preno_cogno',
  30 => 'preno_agenzia',
  31 => 'voucher_id',
  32 => 'ota_voucher',
  33 => 'allotment_id',
  34 => 'preno_cc_tip',
  35 => 'preno_cc_n',
  36 => 'preno_cc_scad',
  37 => 'preno_tel',
  38 => 'preno_fax',
  39 => 'preno_email',
  40 => 'preno_mercato',
  41 => 'nazione_iso2',
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
);
    private const EXPORT_FIELDS = array (
  0 => 'preno_id',
  1 => 'hotel_id',
  2 => 'preno_in_data',
  3 => 'preno_importo',
  4 => 'preno_impoto_mod',
  5 => 'preno_dal',
  6 => 'preno_al',
  7 => 'preno_n_notti',
  8 => 'preno_arr_ore',
  9 => 'preno_trattamento',
  10 => 't1',
  11 => 'q1',
  12 => 'p1',
  13 => 't2',
  14 => 'q2',
  15 => 'p2',
  16 => 't3',
  17 => 'q3',
  18 => 'p3',
  19 => 't4',
  20 => 'q4',
  21 => 'p4',
  22 => 't5',
  23 => 'q5',
  24 => 'p5',
  25 => 't6',
  26 => 'q6',
  27 => 'p6',
  28 => 'preno_nome',
  29 => 'preno_cogno',
  30 => 'preno_agenzia',
  31 => 'voucher_id',
  32 => 'ota_voucher',
  33 => 'allotment_id',
  34 => 'preno_cc_tip',
  35 => 'preno_cc_n',
  36 => 'preno_cc_scad',
  37 => 'preno_tel',
  38 => 'preno_fax',
  39 => 'preno_email',
  40 => 'preno_mercato',
  41 => 'nazione_iso2',
  42 => 'preno_note',
  43 => 'preno_doc_fax',
  44 => 'preno_doc_email',
  45 => 'preno_doc_form',
  46 => 'preno_doc_mail',
  47 => 'preno_doc_vaglia',
  48 => 'preno_doc_woucher',
  49 => 'preno_pag_modalita',
  50 => 'preno_caparra',
  51 => 'preno_stato',
  52 => 'data_opzione',
  53 => 'cancella_user',
  54 => 'cancella_pass',
  55 => 'agenda_utente_id',
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('agenda');
        $builder->select([
            'agenda.preno_id AS preno_id',
            'agenda.hotel_id AS hotel_id',
            'agenda.preno_in_data AS preno_in_data',
            'agenda.preno_importo AS preno_importo',
            'agenda.preno_impoto_mod AS preno_impoto_mod',
            'agenda.preno_dal AS preno_dal',
            'agenda.preno_al AS preno_al',
            'agenda.preno_n_notti AS preno_n_notti',
            'agenda.preno_arr_ore AS preno_arr_ore',
            'agenda.preno_trattamento AS preno_trattamento',
            'agenda.t1 AS t1',
            'agenda.q1 AS q1',
            'agenda.p1 AS p1',
            'agenda.t2 AS t2',
            'agenda.q2 AS q2',
            'agenda.p2 AS p2',
            'agenda.t3 AS t3',
            'agenda.q3 AS q3',
            'agenda.p3 AS p3',
            'agenda.t4 AS t4',
            'agenda.q4 AS q4',
            'agenda.p4 AS p4',
            'agenda.t5 AS t5',
            'agenda.q5 AS q5',
            'agenda.p5 AS p5',
            'agenda.t6 AS t6',
            'agenda.q6 AS q6',
            'agenda.p6 AS p6',
            'agenda.preno_nome AS preno_nome',
            'agenda.preno_cogno AS preno_cogno',
            'agenda.preno_agenzia AS preno_agenzia',
            'agenda.voucher_id AS voucher_id',
            'agenda.ota_voucher AS ota_voucher',
            'agenda.allotment_id AS allotment_id',
            'agenda.preno_cc_tip AS preno_cc_tip',
            'agenda.preno_cc_n AS preno_cc_n',
            'agenda.preno_cc_scad AS preno_cc_scad',
            'agenda.preno_tel AS preno_tel',
            'agenda.preno_fax AS preno_fax',
            'agenda.preno_email AS preno_email',
            'agenda.preno_mercato AS preno_mercato',
            'agenda.nazione_iso2 AS nazione_iso2',
            'agenda.preno_note AS preno_note',
            'agenda.preno_doc_fax AS preno_doc_fax',
            'agenda.preno_doc_email AS preno_doc_email',
            'agenda.preno_doc_form AS preno_doc_form',
            'agenda.preno_doc_mail AS preno_doc_mail',
            'agenda.preno_doc_vaglia AS preno_doc_vaglia',
            'agenda.preno_doc_woucher AS preno_doc_woucher',
            'agenda.preno_pag_modalita AS preno_pag_modalita',
            'agenda.preno_caparra AS preno_caparra',
            'agenda.preno_stato AS preno_stato',
            'agenda.data_opzione AS data_opzione',
            'agenda.cancella_data_record AS cancella_data_record',
            'agenda.cancella_user AS cancella_user',
            'agenda.cancella_pass AS cancella_pass',
            'agenda.preno_data_record AS preno_data_record',
            'agenda.agenda_utente_id AS agenda_utente_id',
            'agenzie__preno_agenzia.agenzia_tipologia AS agenzie_agenzia_tipologia'
        ]);
        $builder->join('agenzie AS agenzie__preno_agenzia', 'agenzie__preno_agenzia.agenzia_id = agenda.preno_agenzia', 'left');
        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('agenda');
        $builder->select([
            'agenda.preno_id AS preno_id',
            'agenda.hotel_id AS hotel_id',
            'agenda.preno_in_data AS preno_in_data',
            'agenda.preno_importo AS preno_importo',
            'agenda.preno_impoto_mod AS preno_impoto_mod',
            'agenda.preno_dal AS preno_dal',
            'agenda.preno_al AS preno_al',
            'agenda.preno_n_notti AS preno_n_notti',
            'agenda.preno_arr_ore AS preno_arr_ore',
            'agenda.preno_trattamento AS preno_trattamento',
            'agenda.t1 AS t1',
            'agenda.q1 AS q1',
            'agenda.p1 AS p1',
            'agenda.t2 AS t2',
            'agenda.q2 AS q2',
            'agenda.p2 AS p2',
            'agenda.t3 AS t3',
            'agenda.q3 AS q3',
            'agenda.p3 AS p3',
            'agenda.t4 AS t4',
            'agenda.q4 AS q4',
            'agenda.p4 AS p4',
            'agenda.t5 AS t5',
            'agenda.q5 AS q5',
            'agenda.p5 AS p5',
            'agenda.t6 AS t6',
            'agenda.q6 AS q6',
            'agenda.p6 AS p6',
            'agenda.preno_nome AS preno_nome',
            'agenda.preno_cogno AS preno_cogno',
            'agenda.preno_agenzia AS preno_agenzia',
            'agenda.voucher_id AS voucher_id',
            'agenda.ota_voucher AS ota_voucher',
            'agenda.allotment_id AS allotment_id',
            'agenda.preno_cc_tip AS preno_cc_tip',
            'agenda.preno_cc_n AS preno_cc_n',
            'agenda.preno_cc_scad AS preno_cc_scad',
            'agenda.preno_tel AS preno_tel',
            'agenda.preno_fax AS preno_fax',
            'agenda.preno_email AS preno_email',
            'agenda.preno_mercato AS preno_mercato',
            'agenda.nazione_iso2 AS nazione_iso2',
            'agenda.preno_doc_fax AS preno_doc_fax',
            'agenda.preno_doc_email AS preno_doc_email',
            'agenda.preno_doc_form AS preno_doc_form',
            'agenda.preno_doc_mail AS preno_doc_mail',
            'agenda.preno_doc_vaglia AS preno_doc_vaglia',
            'agenda.preno_doc_woucher AS preno_doc_woucher',
            'agenda.preno_pag_modalita AS preno_pag_modalita',
            'agenda.preno_caparra AS preno_caparra',
            'agenda.preno_stato AS preno_stato',
            'agenda.data_opzione AS data_opzione',
            'agenda.cancella_data_record AS cancella_data_record',
            'agenzie__preno_agenzia.agenzia_tipologia AS agenzie_agenzia_tipologia'
        ]);
        $builder->join('agenzie AS agenzie__preno_agenzia', 'agenzie__preno_agenzia.agenzia_id = agenda.preno_agenzia', 'left');
        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('agenda');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('agenda.preno_id', $id)
            ->get()
            ->getRow();
    }

    /**
     * Restituisce una pagina HTML-ready con Pager CI4.
     *
     * @return array{rows: array, total: int, page: int, perPage: int, pagerLinks: string, sort: string, direction: string}
     */
    public function getListPage(
        array $filters,
        int $page = 1,
        int $perPage = 25,
        string $sort = 'preno_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'preno_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('agenda.' . $sort, $direction)
            ->limit($perPage, ($page - 1) * $perPage)
            ->get()
            ->getResult();

        $pagerLinks = service('pager')->makeLinks(
            $page,
            $perPage,
            $total,
            'default_full'
        );

        return [
            'rows' => $rows,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'pagerLinks' => $pagerLinks,
            'sort' => $sort,
            'direction' => strtolower($direction),
        ];
    }

    /** Legge il CSV a blocchi usando la chiave primaria come cursore. */
    public function getCsvRows(array $filters, int $limit = 2000, int|string|null $after = null): array
    {
        $builder = $this->db->table('agenda');
        $builder->select([
            'agenda.preno_id AS preno_id',
            'agenda.hotel_id AS hotel_id',
            'agenda.preno_in_data AS preno_in_data',
            'agenda.preno_importo AS preno_importo',
            'agenda.preno_impoto_mod AS preno_impoto_mod',
            'agenda.preno_dal AS preno_dal',
            'agenda.preno_al AS preno_al',
            'agenda.preno_n_notti AS preno_n_notti',
            'agenda.preno_arr_ore AS preno_arr_ore',
            'agenda.preno_trattamento AS preno_trattamento',
            'agenda.t1 AS t1',
            'agenda.q1 AS q1',
            'agenda.p1 AS p1',
            'agenda.t2 AS t2',
            'agenda.q2 AS q2',
            'agenda.p2 AS p2',
            'agenda.t3 AS t3',
            'agenda.q3 AS q3',
            'agenda.p3 AS p3',
            'agenda.t4 AS t4',
            'agenda.q4 AS q4',
            'agenda.p4 AS p4',
            'agenda.t5 AS t5',
            'agenda.q5 AS q5',
            'agenda.p5 AS p5',
            'agenda.t6 AS t6',
            'agenda.q6 AS q6',
            'agenda.p6 AS p6',
            'agenda.preno_nome AS preno_nome',
            'agenda.preno_cogno AS preno_cogno',
            'agenda.preno_agenzia AS preno_agenzia',
            'agenda.voucher_id AS voucher_id',
            'agenda.ota_voucher AS ota_voucher',
            'agenda.allotment_id AS allotment_id',
            'agenda.preno_cc_tip AS preno_cc_tip',
            'agenda.preno_cc_n AS preno_cc_n',
            'agenda.preno_cc_scad AS preno_cc_scad',
            'agenda.preno_tel AS preno_tel',
            'agenda.preno_fax AS preno_fax',
            'agenda.preno_email AS preno_email',
            'agenda.preno_mercato AS preno_mercato',
            'agenda.nazione_iso2 AS nazione_iso2',
            'agenda.preno_note AS preno_note',
            'agenda.preno_doc_fax AS preno_doc_fax',
            'agenda.preno_doc_email AS preno_doc_email',
            'agenda.preno_doc_form AS preno_doc_form',
            'agenda.preno_doc_mail AS preno_doc_mail',
            'agenda.preno_doc_vaglia AS preno_doc_vaglia',
            'agenda.preno_doc_woucher AS preno_doc_woucher',
            'agenda.preno_pag_modalita AS preno_pag_modalita',
            'agenda.preno_caparra AS preno_caparra',
            'agenda.preno_stato AS preno_stato',
            'agenda.data_opzione AS data_opzione',
            'agenda.cancella_user AS cancella_user',
            'agenda.cancella_pass AS cancella_pass',
            'agenda.agenda_utente_id AS agenda_utente_id',
            'agenzie__preno_agenzia.agenzia_tipologia AS agenzie_agenzia_tipologia'
        ]);
        $builder->join('agenzie AS agenzie__preno_agenzia', 'agenzie__preno_agenzia.agenzia_id = agenda.preno_agenzia', 'left');
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('agenda.preno_id >', $after);
        }

        return $builder
            ->orderBy('agenda.preno_id', 'ASC')
            ->limit(max(1, min(5000, $limit)))
            ->get()
            ->getResultArray();
    }

    public function countCsvRows(array $filters): int
    {
        $builder = $this->listCountBuilder();
        $this->applyListFilters($builder, $filters, false);

        return $this->countListRows($builder, $filters);
    }

    /** @return list<string> */
    public function csvFields(): array
    {
        return self::EXPORT_FIELDS;
    }

    private function countListRows(BaseBuilder $builder, array $filters): int
    {
        if ($this->hasActiveFilters($filters) || self::COUNT_CACHE_SECONDS === 0) {
            return $builder->countAllResults();
        }

        $cacheKey = 'mycrud_list_total_' . md5($this->table);
        $cache = service('cache');
        $cached = $cache->get($cacheKey);
        if (is_int($cached) || (is_string($cached) && ctype_digit($cached))) {
            return (int) $cached;
        }

        $total = $builder->countAllResults();
        $cache->save($cacheKey, $total, self::COUNT_CACHE_SECONDS);

        return $total;
    }

    private function hasActiveFilters(array $filters): bool
    {
        foreach ($filters as $value) {
            if (is_array($value)) {
                foreach ($value as $item) {
                    if (is_scalar($item) && trim((string) $item) !== '') {
                        return true;
                    }
                }
                continue;
            }
            if (is_scalar($value) && trim((string) $value) !== '') {
                return true;
            }
        }

        return false;
    }

    public function clearListCountCache(): void
    {
        service('cache')->delete('mycrud_list_total_' . md5($this->table));
    }

    private function applyListFilters(BaseBuilder $builder, array $filters, bool $qualified): void
    {
        foreach (self::LIST_FILTERS as $field => $definition) {
            $column = $qualified ? 'agenda.' . $field : $field;
            $mode = (string) ($definition['mode'] ?? 'exact');
            $value = $filters[$field] ?? null;

            if ($mode === 'range') {
                if (!is_array($value)) {
                    continue;
                }
                $from = trim((string) ($value['from'] ?? ''));
                $to = trim((string) ($value['to'] ?? ''));
                if ($from !== '') {
                    $builder->where($column . ' >=', $from);
                }
                if ($to !== '') {
                    $builder->where($column . ' <=', $to);
                }
                continue;
            }

            if (!is_scalar($value)) {
                continue;
            }

            $value = trim((string) $value);
            if ($value === '') {
                continue;
            }

            if ($mode === 'prefix') {
                if (strlen($value) >= 2) {
                    $builder->like($column, $value, 'after');
                }
                continue;
            }

            $builder->where($column, $value);
        }
    }

    /** Elenco REST paginato con whitelist di filtri e ordinamento. */
    public function apiList(array $query, array $filterable, array $sortable): array
    {
        $page = max(1, (int) ($query['page'] ?? 1));
        $perPage = max(1, min(100, (int) ($query['perPage'] ?? 25)));
        $builder = $this->baseBuilder();

        foreach ((array) ($query['filter'] ?? []) as $field => $value) {
            if (is_scalar($value) && in_array($field, $filterable, true) && (string) $value !== '') {
                $builder->where('agenda.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'preno_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'preno_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('agenda.' . $sort, $direction)
            ->limit($perPage, ($page - 1) * $perPage)
            ->get()
            ->getResult();
        $pageCount = max(1, (int) ceil($total / $perPage));

        return [
            'rows' => $rows,
            'meta' => [
                'page' => $page,
                'perPage' => $perPage,
                'total' => $total,
                'pageCount' => $pageCount,
            ],
            'links' => [
                'self' => $this->apiLink($query, $page),
                'next' => $page < $pageCount ? $this->apiLink($query, $page + 1) : null,
                'prev' => $page > 1 ? $this->apiLink($query, $page - 1) : null,
            ],
        ];
    }

    private function apiLink(array $query, int $page): string
    {
        $query['page'] = $page;
        return current_url() . '?' . http_build_query($query);
    }
    /** Restituisce le opzioni della relazione preno_agenzia. */
    public function getAgenziePrenoAgenziumOptions(): array
    {
        return $this->db->table('agenzie')
            ->select(['agenzia_id', 'agenzia_tipologia'])
            ->orderBy('agenzia_tipologia', 'ASC')
            ->get()
            ->getResult();
    }
    public function relationOptions(): array
    {
        return [
            'preno_agenzia' => $this->toOptions($this->getAgenziePrenoAgenziumOptions(), 'agenzia_id', 'agenzia_tipologia'),
        ];
    }

    private function toOptions(array $rows, string $key, string $label): array
    {
        $options = [];
        foreach ($rows as $row) {
            $options[(string) $row->{$key}] = (string) $row->{$label};
        }
        return $options;
    }

    /** Carica al massimo una riga in più per determinare se esistono altri risultati. */
    public function getCassaByPrenoId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('cassa')
            ->where('preno_id', $parentId)
            ->orderBy('cassa_id', 'DESC')
            ->limit($limit + 1)
            ->get()
            ->getResult();
        $hasMore = count($rows) > $limit;
        if ($hasMore) {
            array_pop($rows);
        }

        return [
            'rows' => $rows,
            'count' => count($rows),
            'hasMore' => $hasMore,
        ];
    }
    /** Carica al massimo una riga in più per determinare se esistono altri risultati. */
    public function getColoriByColPrenoId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('colori')
            ->where('col_preno_id', $parentId)
            ->orderBy('colore_nome', 'DESC')
            ->limit($limit + 1)
            ->get()
            ->getResult();
        $hasMore = count($rows) > $limit;
        if ($hasMore) {
            array_pop($rows);
        }

        return [
            'rows' => $rows,
            'count' => count($rows),
            'hasMore' => $hasMore,
        ];
    }
    /** Carica al massimo una riga in più per determinare se esistono altri risultati. */
    public function getFoglioGiornoByPrenoId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('foglio_giorno')
            ->where('preno_id', $parentId)
            ->orderBy('foglio_id', 'DESC')
            ->limit($limit + 1)
            ->get()
            ->getResult();
        $hasMore = count($rows) > $limit;
        if ($hasMore) {
            array_pop($rows);
        }

        return [
            'rows' => $rows,
            'count' => count($rows),
            'hasMore' => $hasMore,
        ];
    }
    /** Carica al massimo una riga in più per determinare se esistono altri risultati. */
    public function getModificaAgendaByModAgendaId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('modifica_agenda')
            ->where('mod_agenda_id', $parentId)
            ->orderBy('mod_agenda_id', 'DESC')
            ->limit($limit + 1)
            ->get()
            ->getResult();
        $hasMore = count($rows) > $limit;
        if ($hasMore) {
            array_pop($rows);
        }

        return [
            'rows' => $rows,
            'count' => count($rows),
            'hasMore' => $hasMore,
        ];
    }
    /** Carica al massimo una riga in più per determinare se esistono altri risultati. */
    public function getRefAgendaClientiByPrenoId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('ref_agenda_clienti')
            ->where('preno_id', $parentId)
            ->orderBy('ref_agenda_cliente', 'DESC')
            ->limit($limit + 1)
            ->get()
            ->getResult();
        $hasMore = count($rows) > $limit;
        if ($hasMore) {
            array_pop($rows);
        }

        return [
            'rows' => $rows,
            'count' => count($rows),
            'hasMore' => $hasMore,
        ];
    }
    /** Carica al massimo una riga in più per determinare se esistono altri risultati. */
    public function getRefAgenziaPrenoByPrenoId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('ref_agenzia_preno')
            ->where('preno_id', $parentId)
            ->orderBy('ref_agenzia_preno', 'DESC')
            ->limit($limit + 1)
            ->get()
            ->getResult();
        $hasMore = count($rows) > $limit;
        if ($hasMore) {
            array_pop($rows);
        }

        return [
            'rows' => $rows,
            'count' => count($rows),
            'hasMore' => $hasMore,
        ];
    }
    /** Carica al massimo una riga in più per determinare se esistono altri risultati. */
    public function getRefObmpBookingByPrenoId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('ref_obmp_booking')
            ->where('preno_id', $parentId)
            ->orderBy('ref_obm_data', 'DESC')
            ->limit($limit + 1)
            ->get()
            ->getResult();
        $hasMore = count($rows) > $limit;
        if ($hasMore) {
            array_pop($rows);
        }

        return [
            'rows' => $rows,
            'count' => count($rows),
            'hasMore' => $hasMore,
        ];
    }
    public function loadHasMany(int|string $parentId): array
    {
        $result = [];
        $result['cassa__preno_id'] = $this->getCassaByPrenoId($parentId, 20);

        $result['colori__col_preno_id'] = $this->getColoriByColPrenoId($parentId, 20);

        $result['foglio_giorno__preno_id'] = $this->getFoglioGiornoByPrenoId($parentId, 20);

        $result['modifica_agenda__mod_agenda_id'] = $this->getModificaAgendaByModAgendaId($parentId, 20);

        $result['ref_agenda_clienti__preno_id'] = $this->getRefAgendaClientiByPrenoId($parentId, 20);

        $result['ref_agenzia_preno__preno_id'] = $this->getRefAgenziaPrenoByPrenoId($parentId, 20);

        $result['ref_obmp_booking__preno_id'] = $this->getRefObmpBookingByPrenoId($parentId, 20);
        return $result;
    }

}
