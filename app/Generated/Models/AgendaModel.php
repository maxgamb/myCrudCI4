<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\AgendaEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/**
 * Model per la tabella agenda.
 * Tutte le query DB del CRUD sono centralizzate in questa classe.
 */
final class AgendaModel extends Model
{
    protected $table = 'agenda';
    protected $primaryKey = 'preno_id';
    protected $returnType = \App\Entities\AgendaEntity::class;
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

    private const SEARCHABLE_FIELDS = array (
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
  53 => 'cancella_user',
  54 => 'cancella_pass',
  55 => 'preno_data_record',
  56 => 'agenda_utente_id',
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
  53 => 'cancella_user',
  54 => 'cancella_pass',
  55 => 'preno_data_record',
  56 => 'agenda_utente_id',
);

    /** Query base con tutti i LEFT JOIN verso le tabelle padre. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('agenda');
        $builder->select([
            'agenda.*',
            'agenzie.agenzia_tipologia AS agenzie_agenzia_tipologia'
        ]);
        $builder->join('agenzie', 'agenzie.agenzia_id = agenda.preno_agenzia', 'left');

        return $builder;
    }

    /** Restituisce il dettaglio con i dati descrittivi dei parent. */
    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('agenda.preno_id', $id)
            ->get()
            ->getRow();
    }

    /**
     * Paginazione nativa CI4 usata dall'architettura Basic.
     * Il Pager rimane disponibile tramite $this->pager.
     */
    public function paginateWithParents(int $perPage = 25, string $group = 'default', string $search = ''): array
    {
        $this->select([
            'agenda.*',
            'agenzie.agenzia_tipologia AS agenzie_agenzia_tipologia'
        ]);
        $this->join('agenzie', 'agenzie.agenzia_id = agenda.preno_agenzia', 'left');

        if ($search !== '' && self::SEARCHABLE_FIELDS !== []) {
            $this->groupStart();
            foreach (self::SEARCHABLE_FIELDS as $index => $field) {
                $method = $index === 0 ? 'like' : 'orLike';
                $this->{$method}('agenda.' . $field, $search);
            }
            $this->groupEnd();
        }

        $this->orderBy('agenda.preno_id', 'DESC');
        return $this->paginate(max(1, min(200, $perPage)), $group);
    }

    /** Elabora DataTables interamente nel Model. */
    public function datatable(array $request): array
    {
        $draw = (int) ($request['draw'] ?? 1);
        $start = max(0, (int) ($request['start'] ?? 0));
        $length = max(1, min(500, (int) ($request['length'] ?? 25)));
        $search = trim((string) ($request['search']['value'] ?? ''));
        $builder = $this->baseBuilder();

        if ($search !== '' && self::SEARCHABLE_FIELDS !== []) {
            $builder->groupStart();
            foreach (self::SEARCHABLE_FIELDS as $index => $field) {
                $method = $index === 0 ? 'like' : 'orLike';
                $builder->{$method}('agenda.' . $field, $search);
            }
            $builder->groupEnd();
        }

        $recordsTotal = $this->db->table('agenda')->countAllResults();
        $recordsFiltered = (clone $builder)->countAllResults(false);
        $orderIndex = (int) ($request['order'][0]['column'] ?? 0);
        $requestedField = (string) ($request['columns'][$orderIndex]['data'] ?? 'preno_id');
        $orderField = in_array($requestedField, self::SORTABLE_FIELDS, true) ? $requestedField : 'preno_id';
        $orderDirection = strtolower((string) ($request['order'][0]['dir'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';

        foreach ((array) ($request['columns'] ?? []) as $column) {
            $field = (string) ($column['data'] ?? '');
            $value = trim((string) ($column['search']['value'] ?? ''));
            if ($value !== '' && in_array($field, self::SEARCHABLE_FIELDS, true)) {
                $builder->like('agenda.' . $field, $value);
            }
        }

        $rows = $builder->orderBy('agenda.' . $orderField, $orderDirection)
            ->limit($length, $start)
            ->get()
            ->getResult();

        return [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $rows,
        ];
    }

    /** Restituisce le opzioni della relazione preno_agenzia. */
    public function getAgenzieOptions(): array
    {
        return $this->db->table('agenzie')
            ->select(['agenzia_id', 'agenzia_tipologia'])
            ->orderBy('agenzia_tipologia', 'ASC')
            ->get()
            ->getResult();
    }
    /** Restituisce tutte le opzioni belongsTo già indicizzate. */
    public function relationOptions(): array
    {
        return [
            'preno_agenzia' => $this->toOptions($this->getAgenzieOptions(), 'agenzia_id', 'agenzia_tipologia'),
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

    /** Restituisce i record figli dalla tabella cassa. */
    public function getCassaPrenoId(int|string $parentId, int $limit = 20): array
    {
        return $this->db->table('cassa')
            ->where('preno_id', $parentId)
            ->orderBy('cassa_id', 'DESC')
            ->limit(max(1, min(200, $limit)))
            ->get()
            ->getResult();
    }

    /** Conta i record figli dalla tabella cassa. */
    public function countCassaPrenoId(int|string $parentId): int
    {
        return $this->db->table('cassa')
            ->where('preno_id', $parentId)
            ->countAllResults();
    }
    /** Restituisce i record figli dalla tabella colori. */
    public function getColorusColPrenoId(int|string $parentId, int $limit = 20): array
    {
        return $this->db->table('colori')
            ->where('col_preno_id', $parentId)
            ->orderBy('colore_nome', 'DESC')
            ->limit(max(1, min(200, $limit)))
            ->get()
            ->getResult();
    }

    /** Conta i record figli dalla tabella colori. */
    public function countColorusColPrenoId(int|string $parentId): int
    {
        return $this->db->table('colori')
            ->where('col_preno_id', $parentId)
            ->countAllResults();
    }
    /** Restituisce i record figli dalla tabella foglio_giorno. */
    public function getFoglioGiornoPrenoId(int|string $parentId, int $limit = 20): array
    {
        return $this->db->table('foglio_giorno')
            ->where('preno_id', $parentId)
            ->orderBy('foglio_id', 'DESC')
            ->limit(max(1, min(200, $limit)))
            ->get()
            ->getResult();
    }

    /** Conta i record figli dalla tabella foglio_giorno. */
    public function countFoglioGiornoPrenoId(int|string $parentId): int
    {
        return $this->db->table('foglio_giorno')
            ->where('preno_id', $parentId)
            ->countAllResults();
    }
    /** Restituisce i record figli dalla tabella modifica_agenda. */
    public function getModificaAgendaModAgendaId(int|string $parentId, int $limit = 20): array
    {
        return $this->db->table('modifica_agenda')
            ->where('mod_agenda_id', $parentId)
            ->orderBy('mod_agenda_id', 'DESC')
            ->limit(max(1, min(200, $limit)))
            ->get()
            ->getResult();
    }

    /** Conta i record figli dalla tabella modifica_agenda. */
    public function countModificaAgendaModAgendaId(int|string $parentId): int
    {
        return $this->db->table('modifica_agenda')
            ->where('mod_agenda_id', $parentId)
            ->countAllResults();
    }
    /** Restituisce i record figli dalla tabella ref_agenda_clienti. */
    public function getRefAgendaClientusPrenoId(int|string $parentId, int $limit = 20): array
    {
        return $this->db->table('ref_agenda_clienti')
            ->where('preno_id', $parentId)
            ->orderBy('ref_agenda_cliente', 'DESC')
            ->limit(max(1, min(200, $limit)))
            ->get()
            ->getResult();
    }

    /** Conta i record figli dalla tabella ref_agenda_clienti. */
    public function countRefAgendaClientusPrenoId(int|string $parentId): int
    {
        return $this->db->table('ref_agenda_clienti')
            ->where('preno_id', $parentId)
            ->countAllResults();
    }
    /** Restituisce i record figli dalla tabella ref_agenzia_preno. */
    public function getRefAgenziaPrenoPrenoId(int|string $parentId, int $limit = 20): array
    {
        return $this->db->table('ref_agenzia_preno')
            ->where('preno_id', $parentId)
            ->orderBy('ref_agenzia_preno', 'DESC')
            ->limit(max(1, min(200, $limit)))
            ->get()
            ->getResult();
    }

    /** Conta i record figli dalla tabella ref_agenzia_preno. */
    public function countRefAgenziaPrenoPrenoId(int|string $parentId): int
    {
        return $this->db->table('ref_agenzia_preno')
            ->where('preno_id', $parentId)
            ->countAllResults();
    }
    /** Restituisce i record figli dalla tabella ref_obmp_booking. */
    public function getRefObmpBookingPrenoId(int|string $parentId, int $limit = 20): array
    {
        return $this->db->table('ref_obmp_booking')
            ->where('preno_id', $parentId)
            ->orderBy('ref_obm_data', 'DESC')
            ->limit(max(1, min(200, $limit)))
            ->get()
            ->getResult();
    }

    /** Conta i record figli dalla tabella ref_obmp_booking. */
    public function countRefObmpBookingPrenoId(int|string $parentId): int
    {
        return $this->db->table('ref_obmp_booking')
            ->where('preno_id', $parentId)
            ->countAllResults();
    }
    /** Carica i pannelli figli usando metodi query specifici. */
    public function loadHasMany(int|string $parentId): array
    {
        $result = [];
        $rows = $this->getCassaPrenoId($parentId, 20);
        $result['cassa__preno_id'] = [
            'rows' => $rows,
            'count' => true ? $this->countCassaPrenoId($parentId) : count($rows),
        ];

        $rows = $this->getColorusColPrenoId($parentId, 20);
        $result['colori__col_preno_id'] = [
            'rows' => $rows,
            'count' => true ? $this->countColorusColPrenoId($parentId) : count($rows),
        ];

        $rows = $this->getFoglioGiornoPrenoId($parentId, 20);
        $result['foglio_giorno__preno_id'] = [
            'rows' => $rows,
            'count' => true ? $this->countFoglioGiornoPrenoId($parentId) : count($rows),
        ];

        $rows = $this->getModificaAgendaModAgendaId($parentId, 20);
        $result['modifica_agenda__mod_agenda_id'] = [
            'rows' => $rows,
            'count' => true ? $this->countModificaAgendaModAgendaId($parentId) : count($rows),
        ];

        $rows = $this->getRefAgendaClientusPrenoId($parentId, 20);
        $result['ref_agenda_clienti__preno_id'] = [
            'rows' => $rows,
            'count' => true ? $this->countRefAgendaClientusPrenoId($parentId) : count($rows),
        ];

        $rows = $this->getRefAgenziaPrenoPrenoId($parentId, 20);
        $result['ref_agenzia_preno__preno_id'] = [
            'rows' => $rows,
            'count' => true ? $this->countRefAgenziaPrenoPrenoId($parentId) : count($rows),
        ];

        $rows = $this->getRefObmpBookingPrenoId($parentId, 20);
        $result['ref_obmp_booking__preno_id'] = [
            'rows' => $rows,
            'count' => true ? $this->countRefObmpBookingPrenoId($parentId) : count($rows),
        ];
        return $result;
    }

    public function getDeletedList(): array
    {
        return $this->onlyDeleted()->findAll();
    }

    public function restoreRecord(int|string $id): bool
    {
        return $this->builder()->where($this->primaryKey, $id)->update([$this->deletedField => null]);
    }
}
