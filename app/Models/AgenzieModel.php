<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\AgenzieEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per agenzie; tutte le query del CRUD sono centralizzate qui. */
final class AgenzieModel extends Model
{
    protected $table = 'agenzie';
    protected $primaryKey = 'agenzia_id';
    protected $returnType = AgenzieEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'hotel_id',
  1 => 'agenzia_tipologia',
  2 => 'agenzia_nome',
  3 => 'agenzia_via',
  4 => 'agenzia_citta',
  5 => 'agenzia_state',
  6 => 'agenzia_country',
  7 => 'agenzia_cap',
  8 => 'agenzia_tel',
  9 => 'agenzia_fax',
  10 => 'agenzia_email',
  11 => 'agenzia_web',
  12 => 'agenzia_par_iva',
  13 => 'agenzia_par_cf',
  14 => 'agenzia_pec',
  15 => 'agenzia_sid',
  16 => 'agenzia_referente',
  17 => 'agenzia_banca_nome',
  18 => 'agenzia_banca_iban',
  19 => 'agenzia_banca_swift',
  20 => 'agenzia_banca_iata',
  21 => 'agenzia_cc_tipo',
  22 => 'agenzia_cc_nome',
  23 => 'agenzia_cc_numero',
  24 => 'agenzia_cc_scadenza',
  25 => 'agenzia_cc_cod_sicurezza',
  26 => 'agenzia_login',
  27 => 'agenzia_password',
  28 => 'agenzia_ab_web',
  29 => 'agenzia_ab_affiliati',
  30 => 'agenzia_ad_vis',
  31 => 'agenzia_ab_sospeso',
  32 => 'agenzia_data_record',
  33 => 'agenzie_utente_id',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
  'agenzia_id' => 
  array (
    'mode' => 'exact',
    'type' => 'int',
  ),
  'hotel_id' => 
  array (
    'mode' => 'exact',
    'type' => 'int',
  ),
);
    private const SORTABLE_FIELDS = array (
  0 => 'agenzia_id',
  1 => 'hotel_id',
);
    private const EXPORT_FIELDS = array (
  0 => 'agenzia_id',
  1 => 'hotel_id',
  2 => 'agenzia_tipologia',
  3 => 'agenzia_nome',
  4 => 'agenzia_via',
  5 => 'agenzia_citta',
  6 => 'agenzia_state',
  7 => 'agenzia_country',
  8 => 'agenzia_cap',
  9 => 'agenzia_tel',
  10 => 'agenzia_fax',
  11 => 'agenzia_email',
  12 => 'agenzia_web',
  13 => 'agenzia_par_iva',
  14 => 'agenzia_par_cf',
  15 => 'agenzia_pec',
  16 => 'agenzia_sid',
  17 => 'agenzia_referente',
  18 => 'agenzia_banca_nome',
  19 => 'agenzia_banca_iban',
  20 => 'agenzia_banca_swift',
  21 => 'agenzia_banca_iata',
  22 => 'agenzia_cc_tipo',
  23 => 'agenzia_cc_nome',
  24 => 'agenzia_cc_numero',
  25 => 'agenzia_cc_scadenza',
  26 => 'agenzia_cc_cod_sicurezza',
  27 => 'agenzia_login',
  28 => 'agenzia_ab_web',
  29 => 'agenzia_ab_affiliati',
  30 => 'agenzia_ad_vis',
  31 => 'agenzia_ab_sospeso',
  32 => 'agenzia_data_record',
  33 => 'agenzie_utente_id',
);

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('agenzie');
        $builder->select([
            'agenzie.*'
        ]);

        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('agenzie');
        $builder->select([
            'agenzie.agenzia_id AS agenzia_id',
            'agenzie.hotel_id AS hotel_id',
            'agenzie.agenzia_tipologia AS agenzia_tipologia',
            'agenzie.agenzia_nome AS agenzia_nome',
            'agenzie.agenzia_via AS agenzia_via',
            'agenzie.agenzia_citta AS agenzia_citta',
            'agenzie.agenzia_state AS agenzia_state',
            'agenzie.agenzia_country AS agenzia_country',
            'agenzie.agenzia_cap AS agenzia_cap',
            'agenzie.agenzia_tel AS agenzia_tel',
            'agenzie.agenzia_fax AS agenzia_fax',
            'agenzie.agenzia_email AS agenzia_email',
            'agenzie.agenzia_web AS agenzia_web',
            'agenzie.agenzia_par_iva AS agenzia_par_iva',
            'agenzie.agenzia_par_cf AS agenzia_par_cf',
            'agenzie.agenzia_pec AS agenzia_pec',
            'agenzie.agenzia_sid AS agenzia_sid',
            'agenzie.agenzia_referente AS agenzia_referente',
            'agenzie.agenzia_banca_nome AS agenzia_banca_nome',
            'agenzie.agenzia_banca_iban AS agenzia_banca_iban',
            'agenzie.agenzia_banca_swift AS agenzia_banca_swift',
            'agenzie.agenzia_banca_iata AS agenzia_banca_iata',
            'agenzie.agenzia_cc_tipo AS agenzia_cc_tipo',
            'agenzie.agenzia_cc_nome AS agenzia_cc_nome',
            'agenzie.agenzia_cc_numero AS agenzia_cc_numero',
            'agenzie.agenzia_cc_scadenza AS agenzia_cc_scadenza',
            'agenzie.agenzia_cc_cod_sicurezza AS agenzia_cc_cod_sicurezza',
            'agenzie.agenzia_login AS agenzia_login',
            'agenzie.agenzia_ab_web AS agenzia_ab_web',
            'agenzie.agenzia_ab_affiliati AS agenzia_ab_affiliati',
            'agenzie.agenzia_ad_vis AS agenzia_ad_vis',
            'agenzie.agenzia_ab_sospeso AS agenzia_ab_sospeso',
            'agenzie.agenzia_data_record AS agenzia_data_record',
            'agenzie.agenzie_utente_id AS agenzie_utente_id'
        ]);

        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('agenzie');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('agenzie.agenzia_id', $id)
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
        string $sort = 'agenzia_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(10, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'agenzia_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $countBuilder->countAllResults();
        $rows = $dataBuilder
            ->orderBy('agenzie.' . $sort, $direction)
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
        $builder = $this->db->table('agenzie');
        $builder->select([
            'agenzie.agenzia_id AS agenzia_id',
            'agenzie.hotel_id AS hotel_id',
            'agenzie.agenzia_tipologia AS agenzia_tipologia',
            'agenzie.agenzia_nome AS agenzia_nome',
            'agenzie.agenzia_via AS agenzia_via',
            'agenzie.agenzia_citta AS agenzia_citta',
            'agenzie.agenzia_state AS agenzia_state',
            'agenzie.agenzia_country AS agenzia_country',
            'agenzie.agenzia_cap AS agenzia_cap',
            'agenzie.agenzia_tel AS agenzia_tel',
            'agenzie.agenzia_fax AS agenzia_fax',
            'agenzie.agenzia_email AS agenzia_email',
            'agenzie.agenzia_web AS agenzia_web',
            'agenzie.agenzia_par_iva AS agenzia_par_iva',
            'agenzie.agenzia_par_cf AS agenzia_par_cf',
            'agenzie.agenzia_pec AS agenzia_pec',
            'agenzie.agenzia_sid AS agenzia_sid',
            'agenzie.agenzia_referente AS agenzia_referente',
            'agenzie.agenzia_banca_nome AS agenzia_banca_nome',
            'agenzie.agenzia_banca_iban AS agenzia_banca_iban',
            'agenzie.agenzia_banca_swift AS agenzia_banca_swift',
            'agenzie.agenzia_banca_iata AS agenzia_banca_iata',
            'agenzie.agenzia_cc_tipo AS agenzia_cc_tipo',
            'agenzie.agenzia_cc_nome AS agenzia_cc_nome',
            'agenzie.agenzia_cc_numero AS agenzia_cc_numero',
            'agenzie.agenzia_cc_scadenza AS agenzia_cc_scadenza',
            'agenzie.agenzia_cc_cod_sicurezza AS agenzia_cc_cod_sicurezza',
            'agenzie.agenzia_login AS agenzia_login',
            'agenzie.agenzia_ab_web AS agenzia_ab_web',
            'agenzie.agenzia_ab_affiliati AS agenzia_ab_affiliati',
            'agenzie.agenzia_ad_vis AS agenzia_ad_vis',
            'agenzie.agenzia_ab_sospeso AS agenzia_ab_sospeso',
            'agenzie.agenzia_data_record AS agenzia_data_record',
            'agenzie.agenzie_utente_id AS agenzie_utente_id'
        ]);

        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('agenzie.agenzia_id >', $after);
        }

        return $builder
            ->orderBy('agenzie.agenzia_id', 'ASC')
            ->limit(max(1, min(5000, $limit)))
            ->get()
            ->getResultArray();
    }

    public function countCsvRows(array $filters): int
    {
        $builder = $this->listCountBuilder();
        $this->applyListFilters($builder, $filters, false);

        return $builder->countAllResults();
    }

    /** @return list<string> */
    public function csvFields(): array
    {
        return self::EXPORT_FIELDS;
    }

    private function applyListFilters(BaseBuilder $builder, array $filters, bool $qualified): void
    {
        foreach (self::LIST_FILTERS as $field => $definition) {
            $column = $qualified ? 'agenzie.' . $field : $field;
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

    public function relationOptions(): array
    {
        return [

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

    public function getAgendaPrenoAgenzium(int|string $parentId, int $limit = 20): array
    {
        return $this->db->table('agenda')
            ->where('preno_agenzia', $parentId)
            ->orderBy('preno_id', 'DESC')
            ->limit(max(1, min(200, $limit)))
            ->get()
            ->getResult();
    }

    public function countAgendaPrenoAgenzium(int|string $parentId): int
    {
        return $this->db->table('agenda')
            ->where('preno_agenzia', $parentId)
            ->countAllResults();
    }
    public function getFoglioGiornoPrenoAgenzium(int|string $parentId, int $limit = 20): array
    {
        return $this->db->table('foglio_giorno')
            ->where('preno_agenzia', $parentId)
            ->orderBy('foglio_id', 'DESC')
            ->limit(max(1, min(200, $limit)))
            ->get()
            ->getResult();
    }

    public function countFoglioGiornoPrenoAgenzium(int|string $parentId): int
    {
        return $this->db->table('foglio_giorno')
            ->where('preno_agenzia', $parentId)
            ->countAllResults();
    }
    public function getObmpCmAgenziaId(int|string $parentId, int $limit = 20): array
    {
        return $this->db->table('obmp_cm')
            ->where('agenzia_id', $parentId)
            ->orderBy('obmp_cm_id', 'DESC')
            ->limit(max(1, min(200, $limit)))
            ->get()
            ->getResult();
    }

    public function countObmpCmAgenziaId(int|string $parentId): int
    {
        return $this->db->table('obmp_cm')
            ->where('agenzia_id', $parentId)
            ->countAllResults();
    }
    public function getObmpRefEventAgenziaId(int|string $parentId, int $limit = 20): array
    {
        return $this->db->table('obmp_ref_event')
            ->where('agenzia_id', $parentId)
            ->orderBy('ref_event_id', 'DESC')
            ->limit(max(1, min(200, $limit)))
            ->get()
            ->getResult();
    }

    public function countObmpRefEventAgenziaId(int|string $parentId): int
    {
        return $this->db->table('obmp_ref_event')
            ->where('agenzia_id', $parentId)
            ->countAllResults();
    }
    public function getPratichePraticaAgenziaId(int|string $parentId, int $limit = 20): array
    {
        return $this->db->table('pratiche')
            ->where('pratica_agenzia_id', $parentId)
            ->orderBy('pratica_id', 'DESC')
            ->limit(max(1, min(200, $limit)))
            ->get()
            ->getResult();
    }

    public function countPratichePraticaAgenziaId(int|string $parentId): int
    {
        return $this->db->table('pratiche')
            ->where('pratica_agenzia_id', $parentId)
            ->countAllResults();
    }
    public function getRefAgenziaListiniAgenziaId(int|string $parentId, int $limit = 20): array
    {
        return $this->db->table('ref_agenzia_listini')
            ->where('agenzia_id', $parentId)
            ->orderBy('ref_agenzia_listini_id', 'DESC')
            ->limit(max(1, min(200, $limit)))
            ->get()
            ->getResult();
    }

    public function countRefAgenziaListiniAgenziaId(int|string $parentId): int
    {
        return $this->db->table('ref_agenzia_listini')
            ->where('agenzia_id', $parentId)
            ->countAllResults();
    }
    public function getRefAgenziaPrenoAgenziaId(int|string $parentId, int $limit = 20): array
    {
        return $this->db->table('ref_agenzia_preno')
            ->where('agenzia_id', $parentId)
            ->orderBy('ref_agenzia_preno', 'DESC')
            ->limit(max(1, min(200, $limit)))
            ->get()
            ->getResult();
    }

    public function countRefAgenziaPrenoAgenziaId(int|string $parentId): int
    {
        return $this->db->table('ref_agenzia_preno')
            ->where('agenzia_id', $parentId)
            ->countAllResults();
    }
    public function getSospesiSopesoSocietum(int|string $parentId, int $limit = 20): array
    {
        return $this->db->table('sospesi')
            ->where('sopeso_societa', $parentId)
            ->orderBy('sospeso_id', 'DESC')
            ->limit(max(1, min(200, $limit)))
            ->get()
            ->getResult();
    }

    public function countSospesiSopesoSocietum(int|string $parentId): int
    {
        return $this->db->table('sospesi')
            ->where('sopeso_societa', $parentId)
            ->countAllResults();
    }
    public function loadHasMany(int|string $parentId): array
    {
        $result = [];
        $rows = $this->getAgendaPrenoAgenzium($parentId, 20);
        $result['agenda__preno_agenzia'] = [
            'rows' => $rows,
            'count' => true ? $this->countAgendaPrenoAgenzium($parentId) : count($rows),
        ];

        $rows = $this->getFoglioGiornoPrenoAgenzium($parentId, 20);
        $result['foglio_giorno__preno_agenzia'] = [
            'rows' => $rows,
            'count' => true ? $this->countFoglioGiornoPrenoAgenzium($parentId) : count($rows),
        ];

        $rows = $this->getObmpCmAgenziaId($parentId, 20);
        $result['obmp_cm__agenzia_id'] = [
            'rows' => $rows,
            'count' => true ? $this->countObmpCmAgenziaId($parentId) : count($rows),
        ];

        $rows = $this->getObmpRefEventAgenziaId($parentId, 20);
        $result['obmp_ref_event__agenzia_id'] = [
            'rows' => $rows,
            'count' => true ? $this->countObmpRefEventAgenziaId($parentId) : count($rows),
        ];

        $rows = $this->getPratichePraticaAgenziaId($parentId, 20);
        $result['pratiche__pratica_agenzia_id'] = [
            'rows' => $rows,
            'count' => true ? $this->countPratichePraticaAgenziaId($parentId) : count($rows),
        ];

        $rows = $this->getRefAgenziaListiniAgenziaId($parentId, 20);
        $result['ref_agenzia_listini__agenzia_id'] = [
            'rows' => $rows,
            'count' => true ? $this->countRefAgenziaListiniAgenziaId($parentId) : count($rows),
        ];

        $rows = $this->getRefAgenziaPrenoAgenziaId($parentId, 20);
        $result['ref_agenzia_preno__agenzia_id'] = [
            'rows' => $rows,
            'count' => true ? $this->countRefAgenziaPrenoAgenziaId($parentId) : count($rows),
        ];

        $rows = $this->getSospesiSopesoSocietum($parentId, 20);
        $result['sospesi__sopeso_societa'] = [
            'rows' => $rows,
            'count' => true ? $this->countSospesiSopesoSocietum($parentId) : count($rows),
        ];
        return $result;
    }

}
