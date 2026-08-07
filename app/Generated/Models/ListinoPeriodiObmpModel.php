<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\ListinoPeriodiObmpEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per listino_periodi_obmp; tutte le query del CRUD sono centralizzate qui. */
final class ListinoPeriodiObmpModel extends Model
{
    protected $table = 'listino_periodi_obmp';
    protected $primaryKey = 'listino_periodi_id';
    protected $returnType = ListinoPeriodiObmpEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'listino_nome_id',
  1 => 'listino_periodi_flex',
  2 => 'listino_dal',
  3 => 'listino_al',
  4 => 'hotel_id',
  5 => 'listino_periodi',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
  'listino_periodi_id' => 
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
  'listino_nome_id' => 
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
  'listino_dal' => 
  array (
    'type' => 'date',
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
  0 => 'listino_periodi_id',
  1 => 'listino_nome_id',
  2 => 'listino_dal',
);
    private const EXPORT_FIELDS = array (
  0 => 'listino_periodi_id',
  1 => 'listino_nome_id',
  2 => 'listino_periodi_flex',
  3 => 'listino_dal',
  4 => 'listino_al',
  5 => 'hotel_id',
  6 => 'listino_periodi',
);
    private const RELATION_SEARCHES = array (
  'listino_nome_id' => 
  array (
    'table' => 'listino_nome_obmp',
    'key' => 'listino_nome_id',
    'label' => 'listino_nome',
    'mode' => 'select',
  ),
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('listino_periodi_obmp');
        $builder->select([
            'listino_periodi_obmp.listino_periodi_id AS listino_periodi_id',
            'listino_periodi_obmp.listino_nome_id AS listino_nome_id',
            'listino_periodi_obmp.listino_periodi_flex AS listino_periodi_flex',
            'listino_periodi_obmp.listino_dal AS listino_dal',
            'listino_periodi_obmp.listino_al AS listino_al',
            'listino_periodi_obmp.hotel_id AS hotel_id',
            'listino_periodi_obmp.listino_periodi AS listino_periodi',
            'listino_nome_obmp__listino_nome_id.listino_nome AS listino_nome_obmp_listino_nome'
        ]);
        $builder->join('listino_nome_obmp AS listino_nome_obmp__listino_nome_id', 'listino_nome_obmp__listino_nome_id.listino_nome_id = listino_periodi_obmp.listino_nome_id', 'left');
        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('listino_periodi_obmp');
        $builder->select([
            'listino_periodi_obmp.listino_periodi_id AS listino_periodi_id',
            'listino_periodi_obmp.listino_nome_id AS listino_nome_id',
            'listino_periodi_obmp.listino_periodi_flex AS listino_periodi_flex',
            'listino_periodi_obmp.listino_dal AS listino_dal',
            'listino_periodi_obmp.listino_al AS listino_al',
            'listino_periodi_obmp.hotel_id AS hotel_id',
            'listino_periodi_obmp.listino_periodi AS listino_periodi',
            'listino_nome_obmp__listino_nome_id.listino_nome AS listino_nome_obmp_listino_nome'
        ]);
        $builder->join('listino_nome_obmp AS listino_nome_obmp__listino_nome_id', 'listino_nome_obmp__listino_nome_id.listino_nome_id = listino_periodi_obmp.listino_nome_id', 'left');
        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('listino_periodi_obmp');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('listino_periodi_obmp.listino_periodi_id', $id)
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
        string $sort = 'listino_periodi_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'listino_periodi_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('listino_periodi_obmp.' . $sort, $direction)
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
        $builder = $this->db->table('listino_periodi_obmp');
        $builder->select([
            'listino_periodi_obmp.listino_periodi_id AS listino_periodi_id',
            'listino_periodi_obmp.listino_nome_id AS listino_nome_id',
            'listino_periodi_obmp.listino_periodi_flex AS listino_periodi_flex',
            'listino_periodi_obmp.listino_dal AS listino_dal',
            'listino_periodi_obmp.listino_al AS listino_al',
            'listino_periodi_obmp.hotel_id AS hotel_id',
            'listino_periodi_obmp.listino_periodi AS listino_periodi',
            'listino_nome_obmp__listino_nome_id.listino_nome AS listino_nome_obmp_listino_nome'
        ]);
        $builder->join('listino_nome_obmp AS listino_nome_obmp__listino_nome_id', 'listino_nome_obmp__listino_nome_id.listino_nome_id = listino_periodi_obmp.listino_nome_id', 'left');
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('listino_periodi_obmp.listino_periodi_id >', $after);
        }

        return $builder
            ->orderBy('listino_periodi_obmp.listino_periodi_id', 'ASC')
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

            $column = $qualified ? 'listino_periodi_obmp.' . $field : $field;
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
                $builder->where('listino_periodi_obmp.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'listino_periodi_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'listino_periodi_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('listino_periodi_obmp.' . $sort, $direction)
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
    /** Restituisce le opzioni della relazione listino_nome_id. */
    public function getListinoNomeObmpListinoNomeIdOptions(): array
    {
        return $this->db->table('listino_nome_obmp')
            ->select(['listino_nome_id', 'listino_nome'])
            ->orderBy('listino_nome', 'ASC')
            ->get()
            ->getResult();
    }
    public function relationOptions(): array
    {
        return [
            'listino_nome_id' => $this->toOptions($this->getListinoNomeObmpListinoNomeIdOptions(), 'listino_nome_id', 'listino_nome'),
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

    public function loadHasMany(int|string $parentId): array
    {
        $result = [];

        return $result;
    }

}
