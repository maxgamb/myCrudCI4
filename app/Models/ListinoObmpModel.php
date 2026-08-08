<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\ListinoObmpEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per listino_obmp; tutte le query del CRUD sono centralizzate qui. */
final class ListinoObmpModel extends Model
{
    protected $table = 'listino_obmp';
    protected $primaryKey = 'listino_id';
    protected $returnType = ListinoObmpEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'hotel_id',
  1 => 'listino_nome_id',
  2 => 'tipologia_id',
  3 => 'listino_prezzo',
  4 => 'ref_site',
  5 => 'ref_agency',
  6 => 'ref_event',
  7 => 'ref_session',
  8 => 'ref_cookie',
  9 => 'listino_obmp_datarecord',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
  'listino_id' => 
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
  'tipologia_id' => 
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
  0 => 'listino_id',
  1 => 'hotel_id',
  2 => 'listino_nome_id',
  3 => 'tipologia_id',
);
    private const EXPORT_FIELDS = array (
  0 => 'listino_id',
  1 => 'hotel_id',
  2 => 'listino_nome_id',
  3 => 'tipologia_id',
  4 => 'listino_prezzo',
  5 => 'ref_site',
  6 => 'ref_agency',
  7 => 'ref_event',
  8 => 'ref_session',
  9 => 'ref_cookie',
  10 => 'listino_obmp_datarecord',
);
    private const RELATION_SEARCHES = array (
  'listino_nome_id' => 
  array (
    'table' => 'listino_nome_obmp',
    'key' => 'listino_nome_id',
    'displayField' => 'listino_nome',
    'displayTemplate' => '',
    'displayFields' => 
    array (
      0 => 'listino_nome',
    ),
    'mode' => 'select',
  ),
  'tipologia_id' => 
  array (
    'table' => 'obmp_cm_rooms',
    'key' => 'obmp_cm_rooms_id',
    'displayField' => 'obmp_cm_rooms_room_note',
    'displayTemplate' => '',
    'displayFields' => 
    array (
      0 => 'obmp_cm_rooms_room_note',
    ),
    'mode' => 'select',
  ),
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('listino_obmp');
        $builder->select([
            'listino_obmp.listino_id AS listino_id',
            'listino_obmp.hotel_id AS hotel_id',
            'listino_obmp.listino_nome_id AS listino_nome_id',
            'listino_obmp.tipologia_id AS tipologia_id',
            'listino_obmp.listino_prezzo AS listino_prezzo',
            'listino_obmp.ref_site AS ref_site',
            'listino_obmp.ref_agency AS ref_agency',
            'listino_obmp.ref_event AS ref_event',
            'listino_obmp.ref_session AS ref_session',
            'listino_obmp.ref_cookie AS ref_cookie',
            'listino_obmp.listino_obmp_datarecord AS listino_obmp_datarecord',
            'listino_nome_obmp__listino_nome_id.listino_nome AS listino_nome_obmp__listino_nome_id__label',
            'obmp_cm_rooms__tipologia_id.obmp_cm_rooms_room_note AS obmp_cm_rooms__tipologia_id__label'
        ]);
        $builder->join('listino_nome_obmp AS listino_nome_obmp__listino_nome_id', 'listino_nome_obmp__listino_nome_id.listino_nome_id = listino_obmp.listino_nome_id', 'left');
        $builder->join('obmp_cm_rooms AS obmp_cm_rooms__tipologia_id', 'obmp_cm_rooms__tipologia_id.obmp_cm_rooms_id = listino_obmp.tipologia_id', 'left');
        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('listino_obmp');
        $builder->select([
            'listino_obmp.listino_id AS listino_id',
            'listino_obmp.hotel_id AS hotel_id',
            'listino_obmp.listino_nome_id AS listino_nome_id',
            'listino_obmp.tipologia_id AS tipologia_id',
            'listino_obmp.listino_prezzo AS listino_prezzo',
            'listino_obmp.ref_site AS ref_site',
            'listino_obmp.ref_agency AS ref_agency',
            'listino_obmp.ref_event AS ref_event',
            'listino_obmp.ref_session AS ref_session',
            'listino_obmp.ref_cookie AS ref_cookie',
            'listino_nome_obmp__listino_nome_id.listino_nome AS listino_nome_obmp__listino_nome_id__label',
            'obmp_cm_rooms__tipologia_id.obmp_cm_rooms_room_note AS obmp_cm_rooms__tipologia_id__label'
        ]);
        $builder->join('listino_nome_obmp AS listino_nome_obmp__listino_nome_id', 'listino_nome_obmp__listino_nome_id.listino_nome_id = listino_obmp.listino_nome_id', 'left');
        $builder->join('obmp_cm_rooms AS obmp_cm_rooms__tipologia_id', 'obmp_cm_rooms__tipologia_id.obmp_cm_rooms_id = listino_obmp.tipologia_id', 'left');
        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('listino_obmp');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('listino_obmp.listino_id', $id)
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
        string $sort = 'listino_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'listino_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('listino_obmp.' . $sort, $direction)
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
        $builder = $this->db->table('listino_obmp');
        $builder->select([
            'listino_obmp.listino_id AS listino_id',
            'listino_obmp.hotel_id AS hotel_id',
            'listino_obmp.listino_nome_id AS listino_nome_id',
            'listino_obmp.tipologia_id AS tipologia_id',
            'listino_obmp.listino_prezzo AS listino_prezzo',
            'listino_obmp.ref_site AS ref_site',
            'listino_obmp.ref_agency AS ref_agency',
            'listino_obmp.ref_event AS ref_event',
            'listino_obmp.ref_session AS ref_session',
            'listino_obmp.ref_cookie AS ref_cookie',
            'listino_obmp.listino_obmp_datarecord AS listino_obmp_datarecord',
            'listino_nome_obmp__listino_nome_id.listino_nome AS listino_nome_obmp__listino_nome_id__label',
            'obmp_cm_rooms__tipologia_id.obmp_cm_rooms_room_note AS obmp_cm_rooms__tipologia_id__label'
        ]);
        $builder->join('listino_nome_obmp AS listino_nome_obmp__listino_nome_id', 'listino_nome_obmp__listino_nome_id.listino_nome_id = listino_obmp.listino_nome_id', 'left');
        $builder->join('obmp_cm_rooms AS obmp_cm_rooms__tipologia_id', 'obmp_cm_rooms__tipologia_id.obmp_cm_rooms_id = listino_obmp.tipologia_id', 'left');
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('listino_obmp.listino_id >', $after);
        }

        return $builder
            ->orderBy('listino_obmp.listino_id', 'ASC')
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

            $column = $qualified ? 'listino_obmp.' . $field : $field;
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
                $builder->where('listino_obmp.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'listino_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'listino_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('listino_obmp.' . $sort, $direction)
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
            ->select(array (
  0 => 'listino_nome_id',
  1 => 'listino_nome',
))
            ->orderBy('listino_nome', 'ASC')
            ->get()
            ->getResultArray();
    }
    /** Restituisce le opzioni della relazione tipologia_id. */
    public function getObmpCmRoomsTipologiaIdOptions(): array
    {
        return $this->db->table('obmp_cm_rooms')
            ->select(array (
  0 => 'obmp_cm_rooms_id',
  1 => 'obmp_cm_rooms_room_note',
))
            ->orderBy('obmp_cm_rooms_room_note', 'ASC')
            ->get()
            ->getResultArray();
    }
    public function relationOptions(): array
    {
        return [
            'listino_nome_id' => $this->toRelationOptions($this->getListinoNomeObmpListinoNomeIdOptions(), 'listino_nome_id'),
            'tipologia_id' => $this->toRelationOptions($this->getObmpCmRoomsTipologiaIdOptions(), 'tipologia_id'),
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
