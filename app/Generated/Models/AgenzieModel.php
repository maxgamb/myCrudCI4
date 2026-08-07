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
    'type' => 'int',
    'operators' => 
    array (
      0 => 'eq',
      1 => 'neq',
      2 => 'gt',
      3 => 'gte',
      4 => 'lt',
      5 => 'lte',
      6 => 'between',
      7 => 'is_null',
      8 => 'not_null',
    ),
  ),
  'hotel_id' => 
  array (
    'type' => 'int',
    'operators' => 
    array (
      0 => 'eq',
      1 => 'neq',
      2 => 'gt',
      3 => 'gte',
      4 => 'lt',
      5 => 'lte',
      6 => 'between',
      7 => 'is_null',
      8 => 'not_null',
    ),
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
  28 => 'agenzia_password',
  29 => 'agenzia_ab_web',
  30 => 'agenzia_ab_affiliati',
  31 => 'agenzia_ad_vis',
  32 => 'agenzia_ab_sospeso',
  33 => 'agenzie_utente_id',
);
    private const RELATION_SEARCHES = array (
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
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
            'agenzie.agenzia_password AS agenzia_password',
            'agenzie.agenzia_ab_web AS agenzia_ab_web',
            'agenzie.agenzia_ab_affiliati AS agenzia_ab_affiliati',
            'agenzie.agenzia_ad_vis AS agenzia_ad_vis',
            'agenzie.agenzia_ab_sospeso AS agenzia_ab_sospeso',
            'agenzie.agenzia_data_record AS agenzia_data_record',
            'agenzie.agenzie_utente_id AS agenzie_utente_id'
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
            'agenzie.agenzia_tel AS agenzia_tel',
            'agenzie.agenzia_email AS agenzia_email',
            'agenzie.agenzia_banca_nome AS agenzia_banca_nome',
            'agenzie.agenzia_cc_tipo AS agenzia_cc_tipo',
            'agenzie.agenzia_cc_nome AS agenzia_cc_nome'
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
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'agenzia_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('agenzie.' . $sort, $direction)
            ->limit($perPage, ($page - 1) * $perPage)
            ->get()
            ->getResult();

        $pagerLinks = service('pager')->makeLinks(
            $page,
            $perPage,
            $total,
            'bootstrap_full'
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

    /** Legge i record di export a blocchi usando la chiave primaria come cursore. */
    public function getExportRows(array $filters, int $limit = 2000, int|string|null $after = null): array
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
            'agenzie.agenzia_password AS agenzia_password',
            'agenzie.agenzia_ab_web AS agenzia_ab_web',
            'agenzie.agenzia_ab_affiliati AS agenzia_ab_affiliati',
            'agenzie.agenzia_ad_vis AS agenzia_ad_vis',
            'agenzie.agenzia_ab_sospeso AS agenzia_ab_sospeso',
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

    public function countExportRows(array $filters): int
    {
        $builder = $this->listCountBuilder();
        $this->applyListFilters($builder, $filters, false);

        return $this->countListRows($builder, $filters);
    }

    /** @return list<string> */
    public function exportFields(): array
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
        foreach ($filters as $filter) {
            if (is_array($filter) && trim((string) ($filter['field'] ?? '')) !== '') {
                return true;
            }
        }

        return false;
    }

    public function clearListCountCache(): void
    {
        service('cache')->delete('mycrud_list_total_' . md5($this->table));
    }

    /**
     * Applica il filtro dinamico costruito dall'interfaccia del sito.
     * Campo e operatore vengono sempre verificati contro LIST_FILTERS.
     */
    private function applyListFilters(BaseBuilder $builder, array $filters, bool $qualified): void
    {
        $applied = 0;
        $nextLogic = 'and';
        foreach (array_values($filters) as $filter) {
            if (!is_array($filter)) {
                continue;
            }

            $field = trim((string) ($filter['field'] ?? ''));
            $operator = trim((string) ($filter['operator'] ?? ''));
            if ($field === '' || !isset(self::LIST_FILTERS[$field])) {
                continue;
            }

            $definition = self::LIST_FILTERS[$field];
            $allowedOperators = (array) ($definition['operators'] ?? ['eq']);
            if (!in_array($operator, $allowedOperators, true)) {
                continue;
            }

            $column = $qualified ? 'agenzie.' . $field : $field;
            $value = is_scalar($filter['value'] ?? null) ? trim((string) $filter['value']) : '';
            $valueTo = is_scalar($filter['value_to'] ?? null) ? trim((string) $filter['value_to']) : '';
            // La logica appartiene alla riga precedente e collega la
            // condizione appena applicata a quella successiva nell'interfaccia.
            $logic = $applied > 0 ? $nextLogic : 'and';

            if (!in_array($operator, ['is_null', 'not_null'], true) && $value === '') {
                continue;
            }
            if ($operator === 'between' && $valueTo === '') {
                continue;
            }

            // Ogni condizione è raggruppata: AND/OR resta prevedibile anche
            // per operatori composti come BETWEEN.
            if ($logic === 'or') {
                $builder->orGroupStart();
            } else {
                $builder->groupStart();
            }

            switch ($operator) {
                case 'neq':
                    $builder->where($column . ' !=', $value);
                    break;
                case 'gt':
                    $builder->where($column . ' >', $value);
                    break;
                case 'gte':
                    $builder->where($column . ' >=', $value);
                    break;
                case 'lt':
                    $builder->where($column . ' <', $value);
                    break;
                case 'lte':
                    $builder->where($column . ' <=', $value);
                    break;
                case 'between':
                    $builder->where($column . ' >=', $value)
                        ->where($column . ' <=', $valueTo);
                    break;
                case 'starts_with':
                    $builder->like($column, $value, 'after');
                    break;
                case 'contains':
                    $builder->like($column, $value, 'both');
                    break;
                case 'ends_with':
                    $builder->like($column, $value, 'before');
                    break;
                case 'is_null':
                    $builder->where($column, null);
                    break;
                case 'not_null':
                    $builder->where($column . ' IS NOT NULL', null, false);
                    break;
                case 'eq':
                default:
                    $builder->where($column, $value);
                    break;
            }

            $builder->groupEnd();
            $applied++;
            $nextLogic = strtolower((string) ($filter['logic'] ?? 'and')) === 'or' ? 'or' : 'and';
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
                $builder->where('agenzie.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'agenzia_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'agenzia_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('agenzie.' . $sort, $direction)
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
    public function relationOptions(): array
    {
        return [

        ];
    }

    /**
     * Ricerca server-side delle opzioni per relazioni grandi.
     * Tabella, chiave e campo label arrivano solo dalla whitelist generata.
     *
     * @return list<array{id:string,text:string}>
     */
    public function searchRelationOptions(string $field, string $query, int $limit = 20): array
    {
        if (!isset(self::RELATION_SEARCHES[$field])) {
            return [];
        }

        $definition = self::RELATION_SEARCHES[$field];
        $limit = max(1, min(100, $limit));
        $builder = $this->db->table((string) $definition['table'])
            ->select([(string) $definition['key'], (string) $definition['label']])
            ->orderBy((string) $definition['label'], 'ASC')
            ->limit($limit);

        $query = trim($query);
        if ($query !== '') {
            $builder->like((string) $definition['label'], $query, 'after');
        }

        $rows = $builder->get()->getResultArray();
        $result = [];
        foreach ($rows as $row) {
            $result[] = [
                'id' => (string) ($row[(string) $definition['key']] ?? ''),
                'text' => (string) ($row[(string) $definition['label']] ?? ''),
            ];
        }

        return $result;
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
    public function getAgendaByPrenoAgenzia(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('agenda')
            ->where('preno_agenzia', $parentId)
            ->orderBy('preno_id', 'DESC')
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
    public function getFoglioGiornoByPrenoAgenzia(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('foglio_giorno')
            ->where('preno_agenzia', $parentId)
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
    public function getObmpCmByAgenziaId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('obmp_cm')
            ->where('agenzia_id', $parentId)
            ->orderBy('obmp_cm_id', 'DESC')
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
    public function getObmpRefEventByAgenziaId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('obmp_ref_event')
            ->where('agenzia_id', $parentId)
            ->orderBy('ref_event_id', 'DESC')
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
    public function getPraticheByPraticaAgenziaId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('pratiche')
            ->where('pratica_agenzia_id', $parentId)
            ->orderBy('pratica_id', 'DESC')
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
    public function getRefAgenziaListiniByAgenziaId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('ref_agenzia_listini')
            ->where('agenzia_id', $parentId)
            ->orderBy('ref_agenzia_listini_id', 'DESC')
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
    public function getRefAgenziaPrenoByAgenziaId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('ref_agenzia_preno')
            ->where('agenzia_id', $parentId)
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
    public function getSospesiBySopesoSocieta(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('sospesi')
            ->where('sopeso_societa', $parentId)
            ->orderBy('sospeso_id', 'DESC')
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
        $result['agenda__preno_agenzia'] = $this->getAgendaByPrenoAgenzia($parentId, 20);

        $result['foglio_giorno__preno_agenzia'] = $this->getFoglioGiornoByPrenoAgenzia($parentId, 20);

        $result['obmp_cm__agenzia_id'] = $this->getObmpCmByAgenziaId($parentId, 20);

        $result['obmp_ref_event__agenzia_id'] = $this->getObmpRefEventByAgenziaId($parentId, 20);

        $result['pratiche__pratica_agenzia_id'] = $this->getPraticheByPraticaAgenziaId($parentId, 20);

        $result['ref_agenzia_listini__agenzia_id'] = $this->getRefAgenziaListiniByAgenziaId($parentId, 20);

        $result['ref_agenzia_preno__agenzia_id'] = $this->getRefAgenziaPrenoByAgenziaId($parentId, 20);

        $result['sospesi__sopeso_societa'] = $this->getSospesiBySopesoSocieta($parentId, 20);
        return $result;
    }

}
