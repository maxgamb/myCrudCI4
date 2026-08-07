<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\CassaEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per cassa; tutte le query del CRUD sono centralizzate qui. */
final class CassaModel extends Model
{
    protected $table = 'cassa';
    protected $primaryKey = 'cassa_id';
    protected $returnType = CassaEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'hotel_id',
  1 => 'preno_id',
  2 => 'out_conto',
  3 => 'conto_id',
  4 => 'totale_importo',
  5 => 'totale_modificato',
  6 => 'pagamento_importo_pag',
  7 => 'pagamento_forma',
  8 => 'cassa_stato_camera',
  9 => 'sospeso',
  10 => 'fattura_numero',
  11 => 'nome_pagante',
  12 => 'cassa_data_record',
  13 => 'cassa_utente_id',
  14 => 'divisa',
  15 => 'nexi_cod_aut',
  16 => 'nexi_codTrans',
  17 => 'nexi_pan',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
  'cassa_id' => 
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
  'out_conto' => 
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
  'conto_id' => 
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
  0 => 'cassa_id',
  1 => 'hotel_id',
  2 => 'preno_id',
  3 => 'out_conto',
  4 => 'conto_id',
);
    private const EXPORT_FIELDS = array (
  0 => 'cassa_id',
  1 => 'hotel_id',
  2 => 'preno_id',
  3 => 'out_conto',
  4 => 'conto_id',
  5 => 'totale_importo',
  6 => 'totale_modificato',
  7 => 'pagamento_importo_pag',
  8 => 'pagamento_forma',
  9 => 'cassa_stato_camera',
  10 => 'sospeso',
  11 => 'fattura_numero',
  12 => 'nome_pagante',
  13 => 'cassa_utente_id',
  14 => 'divisa',
  15 => 'nexi_cod_aut',
  16 => 'nexi_codTrans',
  17 => 'nexi_pan',
);
    private const RELATION_SEARCHES = array (
  'preno_id' => 
  array (
    'table' => 'agenda',
    'key' => 'preno_id',
    'label' => 'preno_arr_ore',
    'mode' => 'select',
  ),
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('cassa');
        $builder->select([
            'cassa.cassa_id AS cassa_id',
            'cassa.hotel_id AS hotel_id',
            'cassa.preno_id AS preno_id',
            'cassa.out_conto AS out_conto',
            'cassa.conto_id AS conto_id',
            'cassa.totale_importo AS totale_importo',
            'cassa.totale_modificato AS totale_modificato',
            'cassa.pagamento_importo_pag AS pagamento_importo_pag',
            'cassa.pagamento_forma AS pagamento_forma',
            'cassa.cassa_stato_camera AS cassa_stato_camera',
            'cassa.sospeso AS sospeso',
            'cassa.fattura_numero AS fattura_numero',
            'cassa.nome_pagante AS nome_pagante',
            'cassa.cassa_data_record AS cassa_data_record',
            'cassa.cassa_utente_id AS cassa_utente_id',
            'cassa.divisa AS divisa',
            'cassa.nexi_cod_aut AS nexi_cod_aut',
            'cassa.nexi_codTrans AS nexi_codTrans',
            'cassa.nexi_pan AS nexi_pan',
            'agenda__preno_id.preno_arr_ore AS agenda_preno_arr_ore'
        ]);
        $builder->join('agenda AS agenda__preno_id', 'agenda__preno_id.preno_id = cassa.preno_id', 'left');
        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('cassa');
        $builder->select([
            'cassa.cassa_id AS cassa_id',
            'cassa.hotel_id AS hotel_id',
            'cassa.preno_id AS preno_id',
            'cassa.out_conto AS out_conto',
            'cassa.conto_id AS conto_id',
            'cassa.totale_importo AS totale_importo',
            'cassa.totale_modificato AS totale_modificato',
            'cassa.pagamento_importo_pag AS pagamento_importo_pag',
            'cassa.cassa_stato_camera AS cassa_stato_camera',
            'cassa.nome_pagante AS nome_pagante',
            'agenda__preno_id.preno_arr_ore AS agenda_preno_arr_ore'
        ]);
        $builder->join('agenda AS agenda__preno_id', 'agenda__preno_id.preno_id = cassa.preno_id', 'left');
        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('cassa');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('cassa.cassa_id', $id)
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
        string $sort = 'cassa_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'cassa_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('cassa.' . $sort, $direction)
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
        $builder = $this->db->table('cassa');
        $builder->select([
            'cassa.cassa_id AS cassa_id',
            'cassa.hotel_id AS hotel_id',
            'cassa.preno_id AS preno_id',
            'cassa.out_conto AS out_conto',
            'cassa.conto_id AS conto_id',
            'cassa.totale_importo AS totale_importo',
            'cassa.totale_modificato AS totale_modificato',
            'cassa.pagamento_importo_pag AS pagamento_importo_pag',
            'cassa.pagamento_forma AS pagamento_forma',
            'cassa.cassa_stato_camera AS cassa_stato_camera',
            'cassa.sospeso AS sospeso',
            'cassa.fattura_numero AS fattura_numero',
            'cassa.nome_pagante AS nome_pagante',
            'cassa.cassa_utente_id AS cassa_utente_id',
            'cassa.divisa AS divisa',
            'cassa.nexi_cod_aut AS nexi_cod_aut',
            'cassa.nexi_codTrans AS nexi_codTrans',
            'cassa.nexi_pan AS nexi_pan',
            'agenda__preno_id.preno_arr_ore AS agenda_preno_arr_ore'
        ]);
        $builder->join('agenda AS agenda__preno_id', 'agenda__preno_id.preno_id = cassa.preno_id', 'left');
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('cassa.cassa_id >', $after);
        }

        return $builder
            ->orderBy('cassa.cassa_id', 'ASC')
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

            $column = $qualified ? 'cassa.' . $field : $field;
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
                $builder->where('cassa.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'cassa_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'cassa_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('cassa.' . $sort, $direction)
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
            ->select(['preno_id', 'preno_arr_ore'])
            ->orderBy('preno_arr_ore', 'ASC')
            ->get()
            ->getResult();
    }
    public function relationOptions(): array
    {
        return [
            'preno_id' => $this->toOptions($this->getAgendaPrenoIdOptions(), 'preno_id', 'preno_arr_ore'),
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
