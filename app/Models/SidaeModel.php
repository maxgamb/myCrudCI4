<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\SidaeEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per sidae; tutte le query del CRUD sono centralizzate qui. */
final class SidaeModel extends Model
{
    protected $table = 'sidae';
    protected $primaryKey = 'sidae_id';
    protected $returnType = SidaeEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'hotel_id',
  1 => 'conto_id',
  2 => 'foglio_id',
  3 => 'nome_cliente',
  4 => 'pag_room',
  5 => 'aliquota',
  6 => 'quan_room',
  7 => 'pag_extra',
  8 => 'extra_aliquota',
  9 => 'pag_citytax',
  10 => 'pagamentoTipo',
  11 => 'pagamentoCityTax',
  12 => 'codiceLotteria',
  13 => 'stringaLotteria',
  14 => 'se_idTrx',
  15 => 'command',
  16 => 'errore',
  17 => 'ae_idTrx',
  18 => 'numeroDocumento',
  19 => 'numeroRiferimento',
  20 => 'totaleScontrino',
  21 => 'totaleIva',
  22 => 'totaleSconto',
  23 => 'importoDetraibile',
  24 => 'data',
  25 => 'idElemento',
  26 => 'data_record',
  27 => 'utente_id',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
  'sidae_id' => 
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
  'numeroDocumento' => 
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
  'numeroRiferimento' => 
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
  0 => 'sidae_id',
  1 => 'hotel_id',
  2 => 'conto_id',
  3 => 'numeroDocumento',
  4 => 'numeroRiferimento',
);
    private const EXPORT_FIELDS = array (
  0 => 'sidae_id',
  1 => 'hotel_id',
  2 => 'conto_id',
  3 => 'foglio_id',
  4 => 'nome_cliente',
  5 => 'pag_room',
  6 => 'aliquota',
  7 => 'quan_room',
  8 => 'pag_extra',
  9 => 'extra_aliquota',
  10 => 'pag_citytax',
  11 => 'pagamentoTipo',
  12 => 'pagamentoCityTax',
  13 => 'codiceLotteria',
  14 => 'stringaLotteria',
  15 => 'se_idTrx',
  16 => 'command',
  17 => 'errore',
  18 => 'ae_idTrx',
  19 => 'numeroDocumento',
  20 => 'numeroRiferimento',
  21 => 'totaleScontrino',
  22 => 'totaleIva',
  23 => 'totaleSconto',
  24 => 'importoDetraibile',
  25 => 'data',
  26 => 'idElemento',
  27 => 'utente_id',
);
    private const RELATION_SEARCHES = array (
  'conto_id' => 
  array (
    'table' => 'conti',
    'key' => 'conto_id',
    'label' => 'trattamento_sog',
    'mode' => 'select',
  ),
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('sidae');
        $builder->select([
            'sidae.sidae_id AS sidae_id',
            'sidae.hotel_id AS hotel_id',
            'sidae.conto_id AS conto_id',
            'sidae.foglio_id AS foglio_id',
            'sidae.nome_cliente AS nome_cliente',
            'sidae.pag_room AS pag_room',
            'sidae.aliquota AS aliquota',
            'sidae.quan_room AS quan_room',
            'sidae.pag_extra AS pag_extra',
            'sidae.extra_aliquota AS extra_aliquota',
            'sidae.pag_citytax AS pag_citytax',
            'sidae.pagamentoTipo AS pagamentoTipo',
            'sidae.pagamentoCityTax AS pagamentoCityTax',
            'sidae.codiceLotteria AS codiceLotteria',
            'sidae.stringaLotteria AS stringaLotteria',
            'sidae.se_idTrx AS se_idTrx',
            'sidae.command AS command',
            'sidae.errore AS errore',
            'sidae.ae_idTrx AS ae_idTrx',
            'sidae.numeroDocumento AS numeroDocumento',
            'sidae.numeroRiferimento AS numeroRiferimento',
            'sidae.totaleScontrino AS totaleScontrino',
            'sidae.totaleIva AS totaleIva',
            'sidae.totaleSconto AS totaleSconto',
            'sidae.importoDetraibile AS importoDetraibile',
            'sidae.data AS data',
            'sidae.idElemento AS idElemento',
            'sidae.data_record AS data_record',
            'sidae.utente_id AS utente_id',
            'conti__conto_id.trattamento_sog AS conti_trattamento_sog'
        ]);
        $builder->join('conti AS conti__conto_id', 'conti__conto_id.conto_id = sidae.conto_id', 'left');
        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('sidae');
        $builder->select([
            'sidae.sidae_id AS sidae_id',
            'sidae.hotel_id AS hotel_id',
            'sidae.conto_id AS conto_id',
            'sidae.foglio_id AS foglio_id',
            'sidae.nome_cliente AS nome_cliente',
            'sidae.pag_room AS pag_room',
            'sidae.aliquota AS aliquota',
            'sidae.quan_room AS quan_room',
            'sidae.pag_extra AS pag_extra',
            'sidae.data AS data',
            'conti__conto_id.trattamento_sog AS conti_trattamento_sog'
        ]);
        $builder->join('conti AS conti__conto_id', 'conti__conto_id.conto_id = sidae.conto_id', 'left');
        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('sidae');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('sidae.sidae_id', $id)
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
        string $sort = 'sidae_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'sidae_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('sidae.' . $sort, $direction)
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
        $builder = $this->db->table('sidae');
        $builder->select([
            'sidae.sidae_id AS sidae_id',
            'sidae.hotel_id AS hotel_id',
            'sidae.conto_id AS conto_id',
            'sidae.foglio_id AS foglio_id',
            'sidae.nome_cliente AS nome_cliente',
            'sidae.pag_room AS pag_room',
            'sidae.aliquota AS aliquota',
            'sidae.quan_room AS quan_room',
            'sidae.pag_extra AS pag_extra',
            'sidae.extra_aliquota AS extra_aliquota',
            'sidae.pag_citytax AS pag_citytax',
            'sidae.pagamentoTipo AS pagamentoTipo',
            'sidae.pagamentoCityTax AS pagamentoCityTax',
            'sidae.codiceLotteria AS codiceLotteria',
            'sidae.stringaLotteria AS stringaLotteria',
            'sidae.se_idTrx AS se_idTrx',
            'sidae.command AS command',
            'sidae.errore AS errore',
            'sidae.ae_idTrx AS ae_idTrx',
            'sidae.numeroDocumento AS numeroDocumento',
            'sidae.numeroRiferimento AS numeroRiferimento',
            'sidae.totaleScontrino AS totaleScontrino',
            'sidae.totaleIva AS totaleIva',
            'sidae.totaleSconto AS totaleSconto',
            'sidae.importoDetraibile AS importoDetraibile',
            'sidae.data AS data',
            'sidae.idElemento AS idElemento',
            'sidae.utente_id AS utente_id',
            'conti__conto_id.trattamento_sog AS conti_trattamento_sog'
        ]);
        $builder->join('conti AS conti__conto_id', 'conti__conto_id.conto_id = sidae.conto_id', 'left');
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('sidae.sidae_id >', $after);
        }

        return $builder
            ->orderBy('sidae.sidae_id', 'ASC')
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

            $column = $qualified ? 'sidae.' . $field : $field;
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
                $builder->where('sidae.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'sidae_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'sidae_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('sidae.' . $sort, $direction)
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
    /** Restituisce le opzioni della relazione conto_id. */
    public function getContiContoIdOptions(): array
    {
        return $this->db->table('conti')
            ->select(['conto_id', 'trattamento_sog'])
            ->orderBy('trattamento_sog', 'ASC')
            ->get()
            ->getResult();
    }
    public function relationOptions(): array
    {
        return [
            'conto_id' => $this->toOptions($this->getContiContoIdOptions(), 'conto_id', 'trattamento_sog'),
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
