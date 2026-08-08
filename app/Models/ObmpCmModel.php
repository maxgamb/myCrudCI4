<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\ObmpCmEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per obmp_cm; tutte le query del CRUD sono centralizzate qui. */
final class ObmpCmModel extends Model
{
    protected $table = 'obmp_cm';
    protected $primaryKey = 'obmp_cm_id';
    protected $returnType = ObmpCmEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'hotel_id',
  1 => 'agenzia_id',
  2 => 'obmp_cm_id_hotel_agenzia',
  3 => 'obmp_cm_attiva',
  4 => 'obmp_cm_agenzia_url',
  5 => 'obmp_cm_agenzia_user',
  6 => 'obmp_cm_agenzia_password',
  7 => 'obmp_cm_ws_agenzia_url',
  8 => 'obmp_cm_ws_agenzia_user',
  9 => 'obmp_cm_ws_agenzia_password',
  10 => 'obmp_cm_tipologia_id1',
  11 => 'obmp_cm_room_id1',
  12 => 'obmp_cm_tipologia_id2',
  13 => 'obmp_cm_room_id2',
  14 => 'obmp_cm_tipologia_id3',
  15 => 'obmp_cm_room_id3',
  16 => 'obmp_cm_tipologia_id4',
  17 => 'obmp_cm_room_id4',
  18 => 'obmp_cm_tipologia_id5',
  19 => 'obmp_cm_room_id5',
  20 => 'obmp_cm_tipologia_id6',
  21 => 'obmp_cm_room_id6',
  22 => 'obmp_cm_tipologia_id7',
  23 => 'obmp_cm_room_id7',
  24 => 'obmp_cm_tipologia_id8',
  25 => 'obmp_cm_room_id8',
  26 => 'obmp_cm_tipologia_id9',
  27 => 'obmp_cm_room_id9',
  28 => 'obmp_cm_tipologia_id10',
  29 => 'obmp_cm_room_id10',
  30 => 'obmp_cm_moltiplicatore',
  31 => 'obmp_cm_max_camere',
  32 => 'obmp_cm_min_camare',
  33 => 'obmp_cm_utente_id',
  34 => 'obmp_cm_data_record',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
  'obmp_cm_id' => 
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
  'obmp_cm_attiva' => 
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
  0 => 'obmp_cm_id',
  1 => 'hotel_id',
  2 => 'agenzia_id',
  3 => 'obmp_cm_attiva',
);
    private const EXPORT_FIELDS = array (
  0 => 'obmp_cm_id',
  1 => 'hotel_id',
  2 => 'agenzia_id',
  3 => 'obmp_cm_id_hotel_agenzia',
  4 => 'obmp_cm_attiva',
  5 => 'obmp_cm_agenzia_url',
  6 => 'obmp_cm_agenzia_user',
  7 => 'obmp_cm_agenzia_password',
  8 => 'obmp_cm_ws_agenzia_url',
  9 => 'obmp_cm_ws_agenzia_user',
  10 => 'obmp_cm_ws_agenzia_password',
  11 => 'obmp_cm_tipologia_id1',
  12 => 'obmp_cm_room_id1',
  13 => 'obmp_cm_tipologia_id2',
  14 => 'obmp_cm_room_id2',
  15 => 'obmp_cm_tipologia_id3',
  16 => 'obmp_cm_room_id3',
  17 => 'obmp_cm_tipologia_id4',
  18 => 'obmp_cm_room_id4',
  19 => 'obmp_cm_tipologia_id5',
  20 => 'obmp_cm_room_id5',
  21 => 'obmp_cm_tipologia_id6',
  22 => 'obmp_cm_room_id6',
  23 => 'obmp_cm_tipologia_id7',
  24 => 'obmp_cm_room_id7',
  25 => 'obmp_cm_tipologia_id8',
  26 => 'obmp_cm_room_id8',
  27 => 'obmp_cm_tipologia_id9',
  28 => 'obmp_cm_room_id9',
  29 => 'obmp_cm_tipologia_id10',
  30 => 'obmp_cm_room_id10',
  31 => 'obmp_cm_moltiplicatore',
  32 => 'obmp_cm_max_camere',
  33 => 'obmp_cm_min_camare',
  34 => 'obmp_cm_utente_id',
);
    private const RELATION_SEARCHES = array (
  'agenzia_id' => 
  array (
    'table' => 'agenzie',
    'key' => 'agenzia_id',
    'displayField' => 'agenzia_tipologia',
    'displayTemplate' => '',
    'displayFields' => 
    array (
      0 => 'agenzia_tipologia',
    ),
    'mode' => 'select',
  ),
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('obmp_cm');
        $builder->select([
            'obmp_cm.obmp_cm_id AS obmp_cm_id',
            'obmp_cm.hotel_id AS hotel_id',
            'obmp_cm.agenzia_id AS agenzia_id',
            'obmp_cm.obmp_cm_id_hotel_agenzia AS obmp_cm_id_hotel_agenzia',
            'obmp_cm.obmp_cm_attiva AS obmp_cm_attiva',
            'obmp_cm.obmp_cm_agenzia_url AS obmp_cm_agenzia_url',
            'obmp_cm.obmp_cm_agenzia_user AS obmp_cm_agenzia_user',
            'obmp_cm.obmp_cm_agenzia_password AS obmp_cm_agenzia_password',
            'obmp_cm.obmp_cm_ws_agenzia_url AS obmp_cm_ws_agenzia_url',
            'obmp_cm.obmp_cm_ws_agenzia_user AS obmp_cm_ws_agenzia_user',
            'obmp_cm.obmp_cm_ws_agenzia_password AS obmp_cm_ws_agenzia_password',
            'obmp_cm.obmp_cm_tipologia_id1 AS obmp_cm_tipologia_id1',
            'obmp_cm.obmp_cm_room_id1 AS obmp_cm_room_id1',
            'obmp_cm.obmp_cm_tipologia_id2 AS obmp_cm_tipologia_id2',
            'obmp_cm.obmp_cm_room_id2 AS obmp_cm_room_id2',
            'obmp_cm.obmp_cm_tipologia_id3 AS obmp_cm_tipologia_id3',
            'obmp_cm.obmp_cm_room_id3 AS obmp_cm_room_id3',
            'obmp_cm.obmp_cm_tipologia_id4 AS obmp_cm_tipologia_id4',
            'obmp_cm.obmp_cm_room_id4 AS obmp_cm_room_id4',
            'obmp_cm.obmp_cm_tipologia_id5 AS obmp_cm_tipologia_id5',
            'obmp_cm.obmp_cm_room_id5 AS obmp_cm_room_id5',
            'obmp_cm.obmp_cm_tipologia_id6 AS obmp_cm_tipologia_id6',
            'obmp_cm.obmp_cm_room_id6 AS obmp_cm_room_id6',
            'obmp_cm.obmp_cm_tipologia_id7 AS obmp_cm_tipologia_id7',
            'obmp_cm.obmp_cm_room_id7 AS obmp_cm_room_id7',
            'obmp_cm.obmp_cm_tipologia_id8 AS obmp_cm_tipologia_id8',
            'obmp_cm.obmp_cm_room_id8 AS obmp_cm_room_id8',
            'obmp_cm.obmp_cm_tipologia_id9 AS obmp_cm_tipologia_id9',
            'obmp_cm.obmp_cm_room_id9 AS obmp_cm_room_id9',
            'obmp_cm.obmp_cm_tipologia_id10 AS obmp_cm_tipologia_id10',
            'obmp_cm.obmp_cm_room_id10 AS obmp_cm_room_id10',
            'obmp_cm.obmp_cm_moltiplicatore AS obmp_cm_moltiplicatore',
            'obmp_cm.obmp_cm_max_camere AS obmp_cm_max_camere',
            'obmp_cm.obmp_cm_min_camare AS obmp_cm_min_camare',
            'obmp_cm.obmp_cm_utente_id AS obmp_cm_utente_id',
            'obmp_cm.obmp_cm_data_record AS obmp_cm_data_record',
            'agenzie__agenzia_id.agenzia_tipologia AS agenzie__agenzia_id__label'
        ]);
        $builder->join('agenzie AS agenzie__agenzia_id', 'agenzie__agenzia_id.agenzia_id = obmp_cm.agenzia_id', 'left');
        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('obmp_cm');
        $builder->select([
            'obmp_cm.obmp_cm_id AS obmp_cm_id',
            'obmp_cm.hotel_id AS hotel_id',
            'obmp_cm.agenzia_id AS agenzia_id',
            'obmp_cm.obmp_cm_id_hotel_agenzia AS obmp_cm_id_hotel_agenzia',
            'obmp_cm.obmp_cm_attiva AS obmp_cm_attiva',
            'obmp_cm.obmp_cm_agenzia_url AS obmp_cm_agenzia_url',
            'obmp_cm.obmp_cm_agenzia_user AS obmp_cm_agenzia_user',
            'obmp_cm.obmp_cm_agenzia_password AS obmp_cm_agenzia_password',
            'obmp_cm.obmp_cm_ws_agenzia_url AS obmp_cm_ws_agenzia_url',
            'obmp_cm.obmp_cm_ws_agenzia_user AS obmp_cm_ws_agenzia_user',
            'agenzie__agenzia_id.agenzia_tipologia AS agenzie__agenzia_id__label'
        ]);
        $builder->join('agenzie AS agenzie__agenzia_id', 'agenzie__agenzia_id.agenzia_id = obmp_cm.agenzia_id', 'left');
        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('obmp_cm');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('obmp_cm.obmp_cm_id', $id)
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
        string $sort = 'obmp_cm_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'obmp_cm_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('obmp_cm.' . $sort, $direction)
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
        $builder = $this->db->table('obmp_cm');
        $builder->select([
            'obmp_cm.obmp_cm_id AS obmp_cm_id',
            'obmp_cm.hotel_id AS hotel_id',
            'obmp_cm.agenzia_id AS agenzia_id',
            'obmp_cm.obmp_cm_id_hotel_agenzia AS obmp_cm_id_hotel_agenzia',
            'obmp_cm.obmp_cm_attiva AS obmp_cm_attiva',
            'obmp_cm.obmp_cm_agenzia_url AS obmp_cm_agenzia_url',
            'obmp_cm.obmp_cm_agenzia_user AS obmp_cm_agenzia_user',
            'obmp_cm.obmp_cm_agenzia_password AS obmp_cm_agenzia_password',
            'obmp_cm.obmp_cm_ws_agenzia_url AS obmp_cm_ws_agenzia_url',
            'obmp_cm.obmp_cm_ws_agenzia_user AS obmp_cm_ws_agenzia_user',
            'obmp_cm.obmp_cm_ws_agenzia_password AS obmp_cm_ws_agenzia_password',
            'obmp_cm.obmp_cm_tipologia_id1 AS obmp_cm_tipologia_id1',
            'obmp_cm.obmp_cm_room_id1 AS obmp_cm_room_id1',
            'obmp_cm.obmp_cm_tipologia_id2 AS obmp_cm_tipologia_id2',
            'obmp_cm.obmp_cm_room_id2 AS obmp_cm_room_id2',
            'obmp_cm.obmp_cm_tipologia_id3 AS obmp_cm_tipologia_id3',
            'obmp_cm.obmp_cm_room_id3 AS obmp_cm_room_id3',
            'obmp_cm.obmp_cm_tipologia_id4 AS obmp_cm_tipologia_id4',
            'obmp_cm.obmp_cm_room_id4 AS obmp_cm_room_id4',
            'obmp_cm.obmp_cm_tipologia_id5 AS obmp_cm_tipologia_id5',
            'obmp_cm.obmp_cm_room_id5 AS obmp_cm_room_id5',
            'obmp_cm.obmp_cm_tipologia_id6 AS obmp_cm_tipologia_id6',
            'obmp_cm.obmp_cm_room_id6 AS obmp_cm_room_id6',
            'obmp_cm.obmp_cm_tipologia_id7 AS obmp_cm_tipologia_id7',
            'obmp_cm.obmp_cm_room_id7 AS obmp_cm_room_id7',
            'obmp_cm.obmp_cm_tipologia_id8 AS obmp_cm_tipologia_id8',
            'obmp_cm.obmp_cm_room_id8 AS obmp_cm_room_id8',
            'obmp_cm.obmp_cm_tipologia_id9 AS obmp_cm_tipologia_id9',
            'obmp_cm.obmp_cm_room_id9 AS obmp_cm_room_id9',
            'obmp_cm.obmp_cm_tipologia_id10 AS obmp_cm_tipologia_id10',
            'obmp_cm.obmp_cm_room_id10 AS obmp_cm_room_id10',
            'obmp_cm.obmp_cm_moltiplicatore AS obmp_cm_moltiplicatore',
            'obmp_cm.obmp_cm_max_camere AS obmp_cm_max_camere',
            'obmp_cm.obmp_cm_min_camare AS obmp_cm_min_camare',
            'obmp_cm.obmp_cm_utente_id AS obmp_cm_utente_id',
            'agenzie__agenzia_id.agenzia_tipologia AS agenzie__agenzia_id__label'
        ]);
        $builder->join('agenzie AS agenzie__agenzia_id', 'agenzie__agenzia_id.agenzia_id = obmp_cm.agenzia_id', 'left');
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('obmp_cm.obmp_cm_id >', $after);
        }

        return $builder
            ->orderBy('obmp_cm.obmp_cm_id', 'ASC')
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

            $column = $qualified ? 'obmp_cm.' . $field : $field;
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
                $builder->where('obmp_cm.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'obmp_cm_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'obmp_cm_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('obmp_cm.' . $sort, $direction)
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
    /** Restituisce le opzioni della relazione agenzia_id. */
    public function getAgenzieAgenziaIdOptions(): array
    {
        return $this->db->table('agenzie')
            ->select(array (
  0 => 'agenzia_id',
  1 => 'agenzia_tipologia',
))
            ->orderBy('agenzia_tipologia', 'ASC')
            ->get()
            ->getResultArray();
    }
    public function relationOptions(): array
    {
        return [
            'agenzia_id' => $this->toRelationOptions($this->getAgenzieAgenziaIdOptions(), 'agenzia_id'),
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
    public function getObmpCmRoomsByObmpCmId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('obmp_cm_rooms')
            ->where('obmp_cm_id', $parentId)
            ->orderBy('obmp_cm_rooms_id', 'DESC')
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
        $result['obmp_cm_rooms__obmp_cm_id'] = $this->getObmpCmRoomsByObmpCmId($parentId, 20);
        return $result;
    }

}
