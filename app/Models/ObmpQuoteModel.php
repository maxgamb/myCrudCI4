<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\ObmpQuoteEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per obmp_quote; tutte le query del CRUD sono centralizzate qui. */
final class ObmpQuoteModel extends Model
{
    protected $table = 'obmp_quote';
    protected $primaryKey = 'quote_id';
    protected $returnType = ObmpQuoteEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'hotel_id',
  1 => 'quote_lg',
  2 => 'quote_dal',
  3 => 'quote_al',
  4 => 'quote_titolo',
  5 => 'quote_cognome',
  6 => 'quote_nome',
  7 => 'quote_email',
  8 => 'trattamento_id',
  9 => 'trariffa_id',
  10 => 'cax_policy_id',
  11 => 'quote_tel_rich',
  12 => 'quote_cc_rich',
  13 => 'quote_del',
  14 => 'quote_data_time',
  15 => 'utente_id',
  16 => 'quote_stato',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
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
  0 => 'quote_id',
);
    private const EXPORT_FIELDS = array (
  0 => 'quote_id',
  1 => 'hotel_id',
  2 => 'quote_lg',
  3 => 'quote_dal',
  4 => 'quote_al',
  5 => 'quote_titolo',
  6 => 'quote_cognome',
  7 => 'quote_nome',
  8 => 'quote_email',
  9 => 'trattamento_id',
  10 => 'trariffa_id',
  11 => 'cax_policy_id',
  12 => 'quote_tel_rich',
  13 => 'quote_cc_rich',
  14 => 'quote_del',
  15 => 'quote_data_time',
  16 => 'utente_id',
  17 => 'quote_stato',
);
    private const RELATION_SEARCHES = array (
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('obmp_quote');
        $builder->select([
            'obmp_quote.quote_id AS quote_id',
            'obmp_quote.hotel_id AS hotel_id',
            'obmp_quote.quote_lg AS quote_lg',
            'obmp_quote.quote_dal AS quote_dal',
            'obmp_quote.quote_al AS quote_al',
            'obmp_quote.quote_titolo AS quote_titolo',
            'obmp_quote.quote_cognome AS quote_cognome',
            'obmp_quote.quote_nome AS quote_nome',
            'obmp_quote.quote_email AS quote_email',
            'obmp_quote.trattamento_id AS trattamento_id',
            'obmp_quote.trariffa_id AS trariffa_id',
            'obmp_quote.cax_policy_id AS cax_policy_id',
            'obmp_quote.quote_tel_rich AS quote_tel_rich',
            'obmp_quote.quote_cc_rich AS quote_cc_rich',
            'obmp_quote.quote_del AS quote_del',
            'obmp_quote.quote_data_time AS quote_data_time',
            'obmp_quote.utente_id AS utente_id',
            'obmp_quote.quote_stato AS quote_stato'
        ]);

        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('obmp_quote');
        $builder->select([
            'obmp_quote.quote_id AS quote_id',
            'obmp_quote.hotel_id AS hotel_id',
            'obmp_quote.quote_lg AS quote_lg',
            'obmp_quote.quote_dal AS quote_dal',
            'obmp_quote.quote_titolo AS quote_titolo',
            'obmp_quote.quote_nome AS quote_nome',
            'obmp_quote.quote_email AS quote_email',
            'obmp_quote.quote_tel_rich AS quote_tel_rich',
            'obmp_quote.quote_data_time AS quote_data_time',
            'obmp_quote.quote_stato AS quote_stato'
        ]);

        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('obmp_quote');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('obmp_quote.quote_id', $id)
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
        string $sort = 'quote_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'quote_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('obmp_quote.' . $sort, $direction)
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
        $builder = $this->db->table('obmp_quote');
        $builder->select([
            'obmp_quote.quote_id AS quote_id',
            'obmp_quote.hotel_id AS hotel_id',
            'obmp_quote.quote_lg AS quote_lg',
            'obmp_quote.quote_dal AS quote_dal',
            'obmp_quote.quote_al AS quote_al',
            'obmp_quote.quote_titolo AS quote_titolo',
            'obmp_quote.quote_cognome AS quote_cognome',
            'obmp_quote.quote_nome AS quote_nome',
            'obmp_quote.quote_email AS quote_email',
            'obmp_quote.trattamento_id AS trattamento_id',
            'obmp_quote.trariffa_id AS trariffa_id',
            'obmp_quote.cax_policy_id AS cax_policy_id',
            'obmp_quote.quote_tel_rich AS quote_tel_rich',
            'obmp_quote.quote_cc_rich AS quote_cc_rich',
            'obmp_quote.quote_del AS quote_del',
            'obmp_quote.quote_data_time AS quote_data_time',
            'obmp_quote.utente_id AS utente_id',
            'obmp_quote.quote_stato AS quote_stato'
        ]);

        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('obmp_quote.quote_id >', $after);
        }

        return $builder
            ->orderBy('obmp_quote.quote_id', 'ASC')
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

            $column = $qualified ? 'obmp_quote.' . $field : $field;
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
                $builder->where('obmp_quote.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'quote_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'quote_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('obmp_quote.' . $sort, $direction)
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
    public function getObmpQuoteSubByObmpQuoteId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('obmp_quote_sub')
            ->where('obmp_quote_id', $parentId)
            ->orderBy('obmp_quote_sub_id', 'DESC')
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
    public function getRefObmpBookingByQuoteId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('ref_obmp_booking')
            ->where('quote_id', $parentId)
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
        $result['obmp_quote_sub__obmp_quote_id'] = $this->getObmpQuoteSubByObmpQuoteId($parentId, 20);

        $result['ref_obmp_booking__quote_id'] = $this->getRefObmpBookingByQuoteId($parentId, 20);
        return $result;
    }

}
