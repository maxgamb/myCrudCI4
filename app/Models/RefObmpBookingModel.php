<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\RefObmpBookingEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per ref_obmp_booking; tutte le query del CRUD sono centralizzate qui. */
final class RefObmpBookingModel extends Model
{
    protected $table = 'ref_obmp_booking';
    protected $primaryKey = 'ref_obm_data';
    protected $returnType = RefObmpBookingEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'ref_obm_data',
  1 => 'preno_id',
  2 => 'obm_cliente_id',
  3 => 'hotel_id',
  4 => 'ref_site',
  5 => 'ref_agency',
  6 => 'ref_event',
  7 => 'ref_session',
  8 => 'ref_cookie',
  9 => 'room_obmp_string',
  10 => 'quote_id',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
  'ref_obm_data' => 
  array (
    'type' => 'timestamp',
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
  'preno_id' => 
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
  'obm_cliente_id' => 
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
  'ref_site' => 
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
  'quote_id' => 
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
  0 => 'ref_obm_data',
  1 => 'preno_id',
  2 => 'obm_cliente_id',
  3 => 'hotel_id',
  4 => 'ref_site',
  5 => 'quote_id',
);
    private const EXPORT_FIELDS = array (
  0 => 'ref_obm_data',
  1 => 'preno_id',
  2 => 'obm_cliente_id',
  3 => 'hotel_id',
  4 => 'ref_site',
  5 => 'ref_agency',
  6 => 'ref_event',
  7 => 'ref_session',
  8 => 'ref_cookie',
  9 => 'room_obmp_string',
  10 => 'quote_id',
);
    private const RELATION_SEARCHES = array (
  'preno_id' => 
  array (
    'table' => 'agenda',
    'key' => 'preno_id',
    'displayField' => 'preno_arr_ore',
    'displayTemplate' => '',
    'displayFields' => 
    array (
      0 => 'preno_arr_ore',
    ),
    'mode' => 'select',
  ),
  'obm_cliente_id' => 
  array (
    'table' => 'obmp_clienti',
    'key' => 'obm_cliente_id',
    'displayField' => 'obm_cliente_first_name',
    'displayTemplate' => '',
    'displayFields' => 
    array (
      0 => 'obm_cliente_first_name',
    ),
    'mode' => 'select',
  ),
  'quote_id' => 
  array (
    'table' => 'obmp_quote',
    'key' => 'quote_id',
    'displayField' => 'quote_lg',
    'displayTemplate' => '',
    'displayFields' => 
    array (
      0 => 'quote_lg',
    ),
    'mode' => 'select',
  ),
  'ref_site' => 
  array (
    'table' => 'obmp_ref_site',
    'key' => 'ref_site_id',
    'displayField' => 'ref_site_nome',
    'displayTemplate' => '',
    'displayFields' => 
    array (
      0 => 'ref_site_nome',
    ),
    'mode' => 'select',
  ),
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('ref_obmp_booking');
        $builder->select([
            'ref_obmp_booking.ref_obm_data AS ref_obm_data',
            'ref_obmp_booking.preno_id AS preno_id',
            'ref_obmp_booking.obm_cliente_id AS obm_cliente_id',
            'ref_obmp_booking.hotel_id AS hotel_id',
            'ref_obmp_booking.ref_site AS ref_site',
            'ref_obmp_booking.ref_agency AS ref_agency',
            'ref_obmp_booking.ref_event AS ref_event',
            'ref_obmp_booking.ref_session AS ref_session',
            'ref_obmp_booking.ref_cookie AS ref_cookie',
            'ref_obmp_booking.room_obmp_string AS room_obmp_string',
            'ref_obmp_booking.quote_id AS quote_id',
            'agenda__preno_id.preno_arr_ore AS agenda__preno_id__label',
            'obmp_clienti__obm_cliente_id.obm_cliente_first_name AS obmp_clienti__obm_cliente_id__label',
            'obmp_quote__quote_id.quote_lg AS obmp_quote__quote_id__label',
            'obmp_ref_site__ref_site.ref_site_nome AS obmp_ref_site__ref_site__label'
        ]);
        $builder->join('agenda AS agenda__preno_id', 'agenda__preno_id.preno_id = ref_obmp_booking.preno_id', 'left');
        $builder->join('obmp_clienti AS obmp_clienti__obm_cliente_id', 'obmp_clienti__obm_cliente_id.obm_cliente_id = ref_obmp_booking.obm_cliente_id', 'left');
        $builder->join('obmp_quote AS obmp_quote__quote_id', 'obmp_quote__quote_id.quote_id = ref_obmp_booking.quote_id', 'left');
        $builder->join('obmp_ref_site AS obmp_ref_site__ref_site', 'obmp_ref_site__ref_site.ref_site_id = ref_obmp_booking.ref_site', 'left');
        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('ref_obmp_booking');
        $builder->select([
            'ref_obmp_booking.ref_obm_data AS ref_obm_data',
            'ref_obmp_booking.preno_id AS preno_id',
            'ref_obmp_booking.obm_cliente_id AS obm_cliente_id',
            'ref_obmp_booking.hotel_id AS hotel_id',
            'ref_obmp_booking.ref_site AS ref_site',
            'ref_obmp_booking.ref_agency AS ref_agency',
            'ref_obmp_booking.ref_event AS ref_event',
            'ref_obmp_booking.ref_session AS ref_session',
            'ref_obmp_booking.ref_cookie AS ref_cookie',
            'ref_obmp_booking.quote_id AS quote_id',
            'agenda__preno_id.preno_arr_ore AS agenda__preno_id__label',
            'obmp_clienti__obm_cliente_id.obm_cliente_first_name AS obmp_clienti__obm_cliente_id__label',
            'obmp_quote__quote_id.quote_lg AS obmp_quote__quote_id__label',
            'obmp_ref_site__ref_site.ref_site_nome AS obmp_ref_site__ref_site__label'
        ]);
        $builder->join('agenda AS agenda__preno_id', 'agenda__preno_id.preno_id = ref_obmp_booking.preno_id', 'left');
        $builder->join('obmp_clienti AS obmp_clienti__obm_cliente_id', 'obmp_clienti__obm_cliente_id.obm_cliente_id = ref_obmp_booking.obm_cliente_id', 'left');
        $builder->join('obmp_quote AS obmp_quote__quote_id', 'obmp_quote__quote_id.quote_id = ref_obmp_booking.quote_id', 'left');
        $builder->join('obmp_ref_site AS obmp_ref_site__ref_site', 'obmp_ref_site__ref_site.ref_site_id = ref_obmp_booking.ref_site', 'left');
        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('ref_obmp_booking');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('ref_obmp_booking.ref_obm_data', $id)
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
        string $sort = 'ref_obm_data',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'ref_obm_data';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('ref_obmp_booking.' . $sort, $direction)
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
        $builder = $this->db->table('ref_obmp_booking');
        $builder->select([
            'ref_obmp_booking.ref_obm_data AS ref_obm_data',
            'ref_obmp_booking.preno_id AS preno_id',
            'ref_obmp_booking.obm_cliente_id AS obm_cliente_id',
            'ref_obmp_booking.hotel_id AS hotel_id',
            'ref_obmp_booking.ref_site AS ref_site',
            'ref_obmp_booking.ref_agency AS ref_agency',
            'ref_obmp_booking.ref_event AS ref_event',
            'ref_obmp_booking.ref_session AS ref_session',
            'ref_obmp_booking.ref_cookie AS ref_cookie',
            'ref_obmp_booking.room_obmp_string AS room_obmp_string',
            'ref_obmp_booking.quote_id AS quote_id',
            'agenda__preno_id.preno_arr_ore AS agenda__preno_id__label',
            'obmp_clienti__obm_cliente_id.obm_cliente_first_name AS obmp_clienti__obm_cliente_id__label',
            'obmp_quote__quote_id.quote_lg AS obmp_quote__quote_id__label',
            'obmp_ref_site__ref_site.ref_site_nome AS obmp_ref_site__ref_site__label'
        ]);
        $builder->join('agenda AS agenda__preno_id', 'agenda__preno_id.preno_id = ref_obmp_booking.preno_id', 'left');
        $builder->join('obmp_clienti AS obmp_clienti__obm_cliente_id', 'obmp_clienti__obm_cliente_id.obm_cliente_id = ref_obmp_booking.obm_cliente_id', 'left');
        $builder->join('obmp_quote AS obmp_quote__quote_id', 'obmp_quote__quote_id.quote_id = ref_obmp_booking.quote_id', 'left');
        $builder->join('obmp_ref_site AS obmp_ref_site__ref_site', 'obmp_ref_site__ref_site.ref_site_id = ref_obmp_booking.ref_site', 'left');
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('ref_obmp_booking.ref_obm_data >', $after);
        }

        return $builder
            ->orderBy('ref_obmp_booking.ref_obm_data', 'ASC')
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

            $column = $qualified ? 'ref_obmp_booking.' . $field : $field;
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
                $builder->where('ref_obmp_booking.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'ref_obm_data');
        $sort = in_array($sort, $sortable, true) ? $sort : 'ref_obm_data';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('ref_obmp_booking.' . $sort, $direction)
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
    /** Restituisce le opzioni della relazione preno_id. */
    public function getAgendaPrenoIdOptions(): array
    {
        return $this->db->table('agenda')
            ->select(array (
  0 => 'preno_id',
  1 => 'preno_arr_ore',
))
            ->orderBy('preno_arr_ore', 'ASC')
            ->get()
            ->getResultArray();
    }
    /** Restituisce le opzioni della relazione obm_cliente_id. */
    public function getObmpClientiObmClienteIdOptions(): array
    {
        return $this->db->table('obmp_clienti')
            ->select(array (
  0 => 'obm_cliente_id',
  1 => 'obm_cliente_first_name',
))
            ->orderBy('obm_cliente_first_name', 'ASC')
            ->get()
            ->getResultArray();
    }
    /** Restituisce le opzioni della relazione quote_id. */
    public function getObmpQuoteQuoteIdOptions(): array
    {
        return $this->db->table('obmp_quote')
            ->select(array (
  0 => 'quote_id',
  1 => 'quote_lg',
))
            ->orderBy('quote_lg', 'ASC')
            ->get()
            ->getResultArray();
    }
    /** Restituisce le opzioni della relazione ref_site. */
    public function getObmpRefSiteRefSiteOptions(): array
    {
        return $this->db->table('obmp_ref_site')
            ->select(array (
  0 => 'ref_site_id',
  1 => 'ref_site_nome',
))
            ->orderBy('ref_site_nome', 'ASC')
            ->get()
            ->getResultArray();
    }
    public function relationOptions(): array
    {
        return [
            'preno_id' => $this->toRelationOptions($this->getAgendaPrenoIdOptions(), 'preno_id'),
            'obm_cliente_id' => $this->toRelationOptions($this->getObmpClientiObmClienteIdOptions(), 'obm_cliente_id'),
            'quote_id' => $this->toRelationOptions($this->getObmpQuoteQuoteIdOptions(), 'quote_id'),
            'ref_site' => $this->toRelationOptions($this->getObmpRefSiteRefSiteOptions(), 'ref_site'),
        ];
    }

    /**
     * Ricerca server-side delle opzioni per relazioni grandi.
     * Tabella, chiave e campi descrittivi arrivano solo dalla whitelist generata.
     *
     * @return list<array{id:string,text:string}>
     */
    public function searchRelationOptions(string $field, string $query, int $limit = 20): array
    {
        if (!isset(self::RELATION_SEARCHES[$field])) {
            return [];
        }

        $definition = self::RELATION_SEARCHES[$field];
        $key = (string) $definition['key'];
        $displayFields = array_values((array) ($definition['displayFields'] ?? []));
        $selectFields = array_values(array_unique(array_merge([$key], $displayFields)));
        $limit = max(1, min(100, $limit));
        $builder = $this->db->table((string) $definition['table'])
            ->select($selectFields)
            ->orderBy((string) $definition['displayField'], 'ASC')
            ->limit($limit);

        $query = trim($query);
        if ($query !== '' && $displayFields !== []) {
            $builder->groupStart();
            foreach ($displayFields as $index => $displayColumn) {
                if ($index === 0) {
                    $builder->like((string) $displayColumn, $query, 'after');
                } else {
                    $builder->orLike((string) $displayColumn, $query, 'after');
                }
            }
            $builder->groupEnd();
        }

        $rows = $builder->get()->getResultArray();
        $result = [];
        foreach ($rows as $row) {
            $result[] = [
                'id' => (string) ($row[$key] ?? ''),
                'text' => $this->formatRelationLabel($row, $definition),
            ];
        }

        return $result;
    }

    /** Restituisce una FK valida e la sua descrizione; usato dal Create contestuale. */
    public function relationOptionById(string $field, int|string $id): ?array
    {
        if (!isset(self::RELATION_SEARCHES[$field])) {
            return null;
        }

        $definition = self::RELATION_SEARCHES[$field];
        $key = (string) $definition['key'];
        $displayFields = array_values((array) ($definition['displayFields'] ?? []));
        $selectFields = array_values(array_unique(array_merge([$key], $displayFields)));
        $row = $this->db->table((string) $definition['table'])
            ->select($selectFields)
            ->where($key, $id)
            ->limit(1)
            ->get()
            ->getRowArray();

        if (!is_array($row)) {
            return null;
        }

        return [
            'id' => (string) ($row[$key] ?? ''),
            'text' => $this->formatRelationLabel($row, $definition),
        ];
    }

    private function toRelationOptions(array $rows, string $field): array
    {
        if (!isset(self::RELATION_SEARCHES[$field])) {
            return [];
        }

        $definition = self::RELATION_SEARCHES[$field];
        $key = (string) $definition['key'];
        $options = [];
        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }
            $options[(string) ($row[$key] ?? '')] = $this->formatRelationLabel($row, $definition);
        }
        return $options;
    }

    private function formatRelationLabel(array $row, array $definition): string
    {
        $template = trim((string) ($definition['displayTemplate'] ?? ''));
        if ($template === '') {
            return trim((string) ($row[(string) $definition['displayField']] ?? ''));
        }

        $label = preg_replace_callback(
            '/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/',
            static fn (array $match): string => (string) ($row[$match[1]] ?? ''),
            $template
        );

        return trim((string) $label);
    }

    public function loadHasMany(int|string $parentId): array
    {
        $result = [];

        return $result;
    }

}
