<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\ObmpPaymentsEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per obmp_payments; tutte le query del CRUD sono centralizzate qui. */
final class ObmpPaymentsModel extends Model
{
    protected $table = 'obmp_payments';
    protected $primaryKey = 'obmp_payment_id';
    protected $returnType = ObmpPaymentsEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'obmp_payment_cod',
  1 => 'obmp_payment_title',
  2 => 'obmp_payment',
  3 => 'obmp_payment_value',
  4 => 'payment_lg',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
  'obmp_payment_id' => 
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
  'obmp_payment_cod' => 
  array (
    'type' => 'varchar',
    'operators' => 
    array (
      0 => 'eq',
      1 => 'neq',
      2 => 'starts_with',
      3 => 'contains',
      4 => 'ends_with',
      5 => 'is_null',
      6 => 'not_null',
    ),
  ),
);
    private const SORTABLE_FIELDS = array (
  0 => 'obmp_payment_id',
  1 => 'obmp_payment_cod',
);
    private const EXPORT_FIELDS = array (
  0 => 'obmp_payment_id',
  1 => 'obmp_payment_cod',
  2 => 'obmp_payment_title',
  3 => 'obmp_payment',
  4 => 'obmp_payment_value',
  5 => 'payment_lg',
);
    private const RELATION_SEARCHES = array (
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('obmp_payments');
        $builder->select([
            'obmp_payments.obmp_payment_id AS obmp_payment_id',
            'obmp_payments.obmp_payment_cod AS obmp_payment_cod',
            'obmp_payments.obmp_payment_title AS obmp_payment_title',
            'obmp_payments.obmp_payment AS obmp_payment',
            'obmp_payments.obmp_payment_value AS obmp_payment_value',
            'obmp_payments.payment_lg AS payment_lg'
        ]);

        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('obmp_payments');
        $builder->select([
            'obmp_payments.obmp_payment_id AS obmp_payment_id',
            'obmp_payments.obmp_payment_cod AS obmp_payment_cod',
            'obmp_payments.obmp_payment_title AS obmp_payment_title',
            'obmp_payments.obmp_payment AS obmp_payment',
            'obmp_payments.obmp_payment_value AS obmp_payment_value',
            'obmp_payments.payment_lg AS payment_lg'
        ]);

        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('obmp_payments');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('obmp_payments.obmp_payment_id', $id)
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
        string $sort = 'obmp_payment_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'obmp_payment_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('obmp_payments.' . $sort, $direction)
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
        $builder = $this->db->table('obmp_payments');
        $builder->select([
            'obmp_payments.obmp_payment_id AS obmp_payment_id',
            'obmp_payments.obmp_payment_cod AS obmp_payment_cod',
            'obmp_payments.obmp_payment_title AS obmp_payment_title',
            'obmp_payments.obmp_payment AS obmp_payment',
            'obmp_payments.obmp_payment_value AS obmp_payment_value',
            'obmp_payments.payment_lg AS payment_lg'
        ]);

        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('obmp_payments.obmp_payment_id >', $after);
        }

        return $builder
            ->orderBy('obmp_payments.obmp_payment_id', 'ASC')
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

            $column = $qualified ? 'obmp_payments.' . $field : $field;
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
                $builder->where('obmp_payments.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'obmp_payment_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'obmp_payment_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('obmp_payments.' . $sort, $direction)
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

    /** Carica al massimo una riga in più per determinare se esistono altri risultati. */
    public function getObmpRatesByObmpPaymentCod(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('obmp_rates')
            ->where('obmp_payment_cod', $parentId)
            ->orderBy('obmp_rate_id', 'DESC')
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
        $result['obmp_rates__obmp_payment_cod'] = $this->getObmpRatesByObmpPaymentCod($parentId, 20);
        return $result;
    }

}
