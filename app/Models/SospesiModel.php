<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\SospesiEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per sospesi; tutte le query del CRUD sono centralizzate qui. */
final class SospesiModel extends Model
{
    protected $table = 'sospesi';
    protected $primaryKey = 'sospeso_id';
    protected $returnType = SospesiEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'hotel_id',
  1 => 'pagamento_id',
  2 => 'cassa_id',
  3 => 'sospeso_data',
  4 => 'sospeso_conto_id',
  5 => 'sospeso_pratica_id',
  6 => 'sospeso_preno_id',
  7 => 'sospeso_fatt_numero',
  8 => 'sopeso_importo',
  9 => 'sospeso_imp_conto',
  10 => 'sopeso_societa',
  11 => 'sospeso_note',
  12 => 'sospeso_stato',
  13 => 'sospeso_data_record',
  14 => 'sospesi_utente_id',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
  'sospeso_id' => 
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
  'pagamento_id' => 
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
  'sospeso_data' => 
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
  'sospeso_conto_id' => 
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
  'sospeso_pratica_id' => 
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
  'sopeso_societa' => 
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
  0 => 'sospeso_id',
  1 => 'hotel_id',
  2 => 'pagamento_id',
  3 => 'sospeso_data',
  4 => 'sospeso_conto_id',
  5 => 'sospeso_pratica_id',
  6 => 'sopeso_societa',
);
    private const EXPORT_FIELDS = array (
  0 => 'sospeso_id',
  1 => 'hotel_id',
  2 => 'pagamento_id',
  3 => 'cassa_id',
  4 => 'sospeso_data',
  5 => 'sospeso_conto_id',
  6 => 'sospeso_pratica_id',
  7 => 'sospeso_preno_id',
  8 => 'sospeso_fatt_numero',
  9 => 'sopeso_importo',
  10 => 'sospeso_imp_conto',
  11 => 'sopeso_societa',
  12 => 'sospeso_note',
  13 => 'sospeso_stato',
  14 => 'sospesi_utente_id',
);
    private const RELATION_SEARCHES = array (
  'sopeso_societa' => 
  array (
    'table' => 'agenzie',
    'key' => 'agenzia_id',
    'label' => 'agenzia_tipologia',
    'mode' => 'select',
  ),
  'sospeso_pratica_id' => 
  array (
    'table' => 'pratiche',
    'key' => 'pratica_id',
    'label' => 'pratica_nome',
    'mode' => 'select',
  ),
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('sospesi');
        $builder->select([
            'sospesi.sospeso_id AS sospeso_id',
            'sospesi.hotel_id AS hotel_id',
            'sospesi.pagamento_id AS pagamento_id',
            'sospesi.cassa_id AS cassa_id',
            'sospesi.sospeso_data AS sospeso_data',
            'sospesi.sospeso_conto_id AS sospeso_conto_id',
            'sospesi.sospeso_pratica_id AS sospeso_pratica_id',
            'sospesi.sospeso_preno_id AS sospeso_preno_id',
            'sospesi.sospeso_fatt_numero AS sospeso_fatt_numero',
            'sospesi.sopeso_importo AS sopeso_importo',
            'sospesi.sospeso_imp_conto AS sospeso_imp_conto',
            'sospesi.sopeso_societa AS sopeso_societa',
            'sospesi.sospeso_note AS sospeso_note',
            'sospesi.sospeso_stato AS sospeso_stato',
            'sospesi.sospeso_data_record AS sospeso_data_record',
            'sospesi.sospesi_utente_id AS sospesi_utente_id',
            'agenzie__sopeso_societa.agenzia_tipologia AS agenzie_agenzia_tipologia',
            'pratiche__sospeso_pratica_id.pratica_nome AS pratiche_pratica_nome'
        ]);
        $builder->join('agenzie AS agenzie__sopeso_societa', 'agenzie__sopeso_societa.agenzia_id = sospesi.sopeso_societa', 'left');
        $builder->join('pratiche AS pratiche__sospeso_pratica_id', 'pratiche__sospeso_pratica_id.pratica_id = sospesi.sospeso_pratica_id', 'left');
        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('sospesi');
        $builder->select([
            'sospesi.sospeso_id AS sospeso_id',
            'sospesi.hotel_id AS hotel_id',
            'sospesi.pagamento_id AS pagamento_id',
            'sospesi.cassa_id AS cassa_id',
            'sospesi.sospeso_data AS sospeso_data',
            'sospesi.sospeso_conto_id AS sospeso_conto_id',
            'sospesi.sospeso_pratica_id AS sospeso_pratica_id',
            'sospesi.sopeso_importo AS sopeso_importo',
            'sospesi.sopeso_societa AS sopeso_societa',
            'sospesi.sospeso_stato AS sospeso_stato',
            'agenzie__sopeso_societa.agenzia_tipologia AS agenzie_agenzia_tipologia',
            'pratiche__sospeso_pratica_id.pratica_nome AS pratiche_pratica_nome'
        ]);
        $builder->join('agenzie AS agenzie__sopeso_societa', 'agenzie__sopeso_societa.agenzia_id = sospesi.sopeso_societa', 'left');
        $builder->join('pratiche AS pratiche__sospeso_pratica_id', 'pratiche__sospeso_pratica_id.pratica_id = sospesi.sospeso_pratica_id', 'left');
        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('sospesi');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('sospesi.sospeso_id', $id)
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
        string $sort = 'sospeso_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'sospeso_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('sospesi.' . $sort, $direction)
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
        $builder = $this->db->table('sospesi');
        $builder->select([
            'sospesi.sospeso_id AS sospeso_id',
            'sospesi.hotel_id AS hotel_id',
            'sospesi.pagamento_id AS pagamento_id',
            'sospesi.cassa_id AS cassa_id',
            'sospesi.sospeso_data AS sospeso_data',
            'sospesi.sospeso_conto_id AS sospeso_conto_id',
            'sospesi.sospeso_pratica_id AS sospeso_pratica_id',
            'sospesi.sospeso_preno_id AS sospeso_preno_id',
            'sospesi.sospeso_fatt_numero AS sospeso_fatt_numero',
            'sospesi.sopeso_importo AS sopeso_importo',
            'sospesi.sospeso_imp_conto AS sospeso_imp_conto',
            'sospesi.sopeso_societa AS sopeso_societa',
            'sospesi.sospeso_note AS sospeso_note',
            'sospesi.sospeso_stato AS sospeso_stato',
            'sospesi.sospesi_utente_id AS sospesi_utente_id',
            'agenzie__sopeso_societa.agenzia_tipologia AS agenzie_agenzia_tipologia',
            'pratiche__sospeso_pratica_id.pratica_nome AS pratiche_pratica_nome'
        ]);
        $builder->join('agenzie AS agenzie__sopeso_societa', 'agenzie__sopeso_societa.agenzia_id = sospesi.sopeso_societa', 'left');
        $builder->join('pratiche AS pratiche__sospeso_pratica_id', 'pratiche__sospeso_pratica_id.pratica_id = sospesi.sospeso_pratica_id', 'left');
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('sospesi.sospeso_id >', $after);
        }

        return $builder
            ->orderBy('sospesi.sospeso_id', 'ASC')
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

            $column = $qualified ? 'sospesi.' . $field : $field;
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
                $builder->where('sospesi.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'sospeso_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'sospeso_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('sospesi.' . $sort, $direction)
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
    /** Restituisce le opzioni della relazione sopeso_societa. */
    public function getAgenzieSopesoSocietaOptions(): array
    {
        return $this->db->table('agenzie')
            ->select(['agenzia_id', 'agenzia_tipologia'])
            ->orderBy('agenzia_tipologia', 'ASC')
            ->get()
            ->getResult();
    }
    /** Restituisce le opzioni della relazione sospeso_pratica_id. */
    public function getPraticheSospesoPraticaIdOptions(): array
    {
        return $this->db->table('pratiche')
            ->select(['pratica_id', 'pratica_nome'])
            ->orderBy('pratica_nome', 'ASC')
            ->get()
            ->getResult();
    }
    public function relationOptions(): array
    {
        return [
            'sopeso_societa' => $this->toOptions($this->getAgenzieSopesoSocietaOptions(), 'agenzia_id', 'agenzia_tipologia'),
            'sospeso_pratica_id' => $this->toOptions($this->getPraticheSospesoPraticaIdOptions(), 'pratica_id', 'pratica_nome'),
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
    public function getPagamentiSospesiBySospesoId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('pagamenti_sospesi')
            ->where('sospeso_id', $parentId)
            ->orderBy('pagamento_id', 'DESC')
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
        $result['pagamenti_sospesi__sospeso_id'] = $this->getPagamentiSospesiBySospesoId($parentId, 20);
        return $result;
    }

}
