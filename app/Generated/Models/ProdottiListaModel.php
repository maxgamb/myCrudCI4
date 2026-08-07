<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\ProdottiListaEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per prodotti_lista; tutte le query del CRUD sono centralizzate qui. */
final class ProdottiListaModel extends Model
{
    protected $table = 'prodotti_lista';
    protected $primaryKey = 'prodotti_lista_id';
    protected $returnType = ProdottiListaEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'prod_lista_mone',
  1 => 'prod_lista_descrixione',
  2 => 'prod_lista_allergenici',
  3 => 'prod_lista_costo_unitario',
  4 => 'prod_lista_img',
  5 => 'prod_lista_data',
  6 => 'prod_lista_user_id',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
  'prodotti_lista_id' => 
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
  0 => 'prodotti_lista_id',
);
    private const EXPORT_FIELDS = array (
  0 => 'prodotti_lista_id',
  1 => 'prod_lista_mone',
  2 => 'prod_lista_descrixione',
  3 => 'prod_lista_allergenici',
  4 => 'prod_lista_costo_unitario',
  5 => 'prod_lista_img',
  6 => 'prod_lista_data',
  7 => 'prod_lista_user_id',
);
    private const RELATION_SEARCHES = array (
  'prodotti_lista_id' => 
  array (
    'table' => 'prodotti',
    'key' => 'prodotto_id',
    'label' => 'nome_prodotto',
    'mode' => 'select',
  ),
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('prodotti_lista');
        $builder->select([
            'prodotti_lista.prodotti_lista_id AS prodotti_lista_id',
            'prodotti_lista.prod_lista_mone AS prod_lista_mone',
            'prodotti_lista.prod_lista_descrixione AS prod_lista_descrixione',
            'prodotti_lista.prod_lista_allergenici AS prod_lista_allergenici',
            'prodotti_lista.prod_lista_costo_unitario AS prod_lista_costo_unitario',
            'prodotti_lista.prod_lista_img AS prod_lista_img',
            'prodotti_lista.prod_lista_data AS prod_lista_data',
            'prodotti_lista.prod_lista_user_id AS prod_lista_user_id',
            'prodotti__prodotti_lista_id.nome_prodotto AS prodotti_nome_prodotto'
        ]);
        $builder->join('prodotti AS prodotti__prodotti_lista_id', 'prodotti__prodotti_lista_id.prodotto_id = prodotti_lista.prodotti_lista_id', 'left');
        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('prodotti_lista');
        $builder->select([
            'prodotti_lista.prodotti_lista_id AS prodotti_lista_id',
            'prodotti_lista.prod_lista_mone AS prod_lista_mone',
            'prodotti_lista.prod_lista_descrixione AS prod_lista_descrixione',
            'prodotti_lista.prod_lista_allergenici AS prod_lista_allergenici',
            'prodotti_lista.prod_lista_costo_unitario AS prod_lista_costo_unitario',
            'prodotti_lista.prod_lista_img AS prod_lista_img',
            'prodotti_lista.prod_lista_data AS prod_lista_data',
            'prodotti_lista.prod_lista_user_id AS prod_lista_user_id',
            'prodotti__prodotti_lista_id.nome_prodotto AS prodotti_nome_prodotto'
        ]);
        $builder->join('prodotti AS prodotti__prodotti_lista_id', 'prodotti__prodotti_lista_id.prodotto_id = prodotti_lista.prodotti_lista_id', 'left');
        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('prodotti_lista');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('prodotti_lista.prodotti_lista_id', $id)
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
        string $sort = 'prodotti_lista_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'prodotti_lista_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('prodotti_lista.' . $sort, $direction)
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
        $builder = $this->db->table('prodotti_lista');
        $builder->select([
            'prodotti_lista.prodotti_lista_id AS prodotti_lista_id',
            'prodotti_lista.prod_lista_mone AS prod_lista_mone',
            'prodotti_lista.prod_lista_descrixione AS prod_lista_descrixione',
            'prodotti_lista.prod_lista_allergenici AS prod_lista_allergenici',
            'prodotti_lista.prod_lista_costo_unitario AS prod_lista_costo_unitario',
            'prodotti_lista.prod_lista_img AS prod_lista_img',
            'prodotti_lista.prod_lista_data AS prod_lista_data',
            'prodotti_lista.prod_lista_user_id AS prod_lista_user_id',
            'prodotti__prodotti_lista_id.nome_prodotto AS prodotti_nome_prodotto'
        ]);
        $builder->join('prodotti AS prodotti__prodotti_lista_id', 'prodotti__prodotti_lista_id.prodotto_id = prodotti_lista.prodotti_lista_id', 'left');
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('prodotti_lista.prodotti_lista_id >', $after);
        }

        return $builder
            ->orderBy('prodotti_lista.prodotti_lista_id', 'ASC')
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

            $column = $qualified ? 'prodotti_lista.' . $field : $field;
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
                $builder->where('prodotti_lista.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'prodotti_lista_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'prodotti_lista_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('prodotti_lista.' . $sort, $direction)
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
    /** Restituisce le opzioni della relazione prodotti_lista_id. */
    public function getProdottiProdottiListaIdOptions(): array
    {
        return $this->db->table('prodotti')
            ->select(['prodotto_id', 'nome_prodotto'])
            ->orderBy('nome_prodotto', 'ASC')
            ->get()
            ->getResult();
    }
    public function relationOptions(): array
    {
        return [
            'prodotti_lista_id' => $this->toOptions($this->getProdottiProdottiListaIdOptions(), 'prodotto_id', 'nome_prodotto'),
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
