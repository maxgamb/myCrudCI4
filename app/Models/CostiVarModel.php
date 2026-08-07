<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\CostiVarEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per costi_var; tutte le query del CRUD sono centralizzate qui. */
final class CostiVarModel extends Model
{
    protected $table = 'costi_var';
    protected $primaryKey = 'costi_var_id';
    protected $returnType = CostiVarEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'costi_area_id',
  1 => 'costi_var_sub_1',
  2 => 'costi_var_sub_2',
  3 => 'hotel_id',
  4 => 'costi_var_codice',
  5 => 'costi_var_nome',
  6 => 'costi_var_deposito',
  7 => 'mag_quantita',
  8 => 'costi_var_prezzo_uso',
  9 => 'mag_prezzo_lavaggio',
  10 => 'costi_var_addebbito',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
  'costi_var_id' => 
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
  'costi_area_id' => 
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
  0 => 'costi_var_id',
  1 => 'costi_area_id',
);
    private const EXPORT_FIELDS = array (
  0 => 'costi_var_id',
  1 => 'costi_area_id',
  2 => 'costi_var_sub_1',
  3 => 'costi_var_sub_2',
  4 => 'hotel_id',
  5 => 'costi_var_codice',
  6 => 'costi_var_nome',
  7 => 'costi_var_deposito',
  8 => 'mag_quantita',
  9 => 'costi_var_prezzo_uso',
  10 => 'mag_prezzo_lavaggio',
  11 => 'costi_var_addebbito',
);
    private const RELATION_SEARCHES = array (
  'costi_area_id' => 
  array (
    'table' => 'costi_area',
    'key' => 'costi_area_id',
    'label' => 'costi_area_nome',
    'mode' => 'select',
  ),
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('costi_var');
        $builder->select([
            'costi_var.costi_var_id AS costi_var_id',
            'costi_var.costi_area_id AS costi_area_id',
            'costi_var.costi_var_sub_1 AS costi_var_sub_1',
            'costi_var.costi_var_sub_2 AS costi_var_sub_2',
            'costi_var.hotel_id AS hotel_id',
            'costi_var.costi_var_codice AS costi_var_codice',
            'costi_var.costi_var_nome AS costi_var_nome',
            'costi_var.costi_var_deposito AS costi_var_deposito',
            'costi_var.mag_quantita AS mag_quantita',
            'costi_var.costi_var_prezzo_uso AS costi_var_prezzo_uso',
            'costi_var.mag_prezzo_lavaggio AS mag_prezzo_lavaggio',
            'costi_var.costi_var_addebbito AS costi_var_addebbito',
            'costi_area__costi_area_id.costi_area_nome AS costi_area_costi_area_nome'
        ]);
        $builder->join('costi_area AS costi_area__costi_area_id', 'costi_area__costi_area_id.costi_area_id = costi_var.costi_area_id', 'left');
        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('costi_var');
        $builder->select([
            'costi_var.costi_var_id AS costi_var_id',
            'costi_var.costi_area_id AS costi_area_id',
            'costi_var.costi_var_sub_1 AS costi_var_sub_1',
            'costi_var.costi_var_sub_2 AS costi_var_sub_2',
            'costi_var.hotel_id AS hotel_id',
            'costi_var.costi_var_codice AS costi_var_codice',
            'costi_var.costi_var_nome AS costi_var_nome',
            'costi_var.mag_quantita AS mag_quantita',
            'costi_var.costi_var_prezzo_uso AS costi_var_prezzo_uso',
            'costi_var.mag_prezzo_lavaggio AS mag_prezzo_lavaggio',
            'costi_area__costi_area_id.costi_area_nome AS costi_area_costi_area_nome'
        ]);
        $builder->join('costi_area AS costi_area__costi_area_id', 'costi_area__costi_area_id.costi_area_id = costi_var.costi_area_id', 'left');
        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('costi_var');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('costi_var.costi_var_id', $id)
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
        string $sort = 'costi_var_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'costi_var_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('costi_var.' . $sort, $direction)
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
        $builder = $this->db->table('costi_var');
        $builder->select([
            'costi_var.costi_var_id AS costi_var_id',
            'costi_var.costi_area_id AS costi_area_id',
            'costi_var.costi_var_sub_1 AS costi_var_sub_1',
            'costi_var.costi_var_sub_2 AS costi_var_sub_2',
            'costi_var.hotel_id AS hotel_id',
            'costi_var.costi_var_codice AS costi_var_codice',
            'costi_var.costi_var_nome AS costi_var_nome',
            'costi_var.costi_var_deposito AS costi_var_deposito',
            'costi_var.mag_quantita AS mag_quantita',
            'costi_var.costi_var_prezzo_uso AS costi_var_prezzo_uso',
            'costi_var.mag_prezzo_lavaggio AS mag_prezzo_lavaggio',
            'costi_var.costi_var_addebbito AS costi_var_addebbito',
            'costi_area__costi_area_id.costi_area_nome AS costi_area_costi_area_nome'
        ]);
        $builder->join('costi_area AS costi_area__costi_area_id', 'costi_area__costi_area_id.costi_area_id = costi_var.costi_area_id', 'left');
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('costi_var.costi_var_id >', $after);
        }

        return $builder
            ->orderBy('costi_var.costi_var_id', 'ASC')
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

            $column = $qualified ? 'costi_var.' . $field : $field;
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
                $builder->where('costi_var.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'costi_var_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'costi_var_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('costi_var.' . $sort, $direction)
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
    /** Restituisce le opzioni della relazione costi_area_id. */
    public function getCostiAreaCostiAreaIdOptions(): array
    {
        return $this->db->table('costi_area')
            ->select(['costi_area_id', 'costi_area_nome'])
            ->orderBy('costi_area_nome', 'ASC')
            ->get()
            ->getResult();
    }
    public function relationOptions(): array
    {
        return [
            'costi_area_id' => $this->toOptions($this->getCostiAreaCostiAreaIdOptions(), 'costi_area_id', 'costi_area_nome'),
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
    public function getRefCostiTipologiaByCostiVarId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('ref_costi_tipologia')
            ->where('costi_var_id', $parentId)
            ->orderBy('ref_costi_tipologia_id', 'DESC')
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
        $result['ref_costi_tipologia__costi_var_id'] = $this->getRefCostiTipologiaByCostiVarId($parentId, 20);
        return $result;
    }

}
