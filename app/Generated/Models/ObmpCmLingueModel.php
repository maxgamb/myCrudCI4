<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\ObmpCmLingueEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per obmp_cm_lingue; tutte le query del CRUD sono centralizzate qui. */
final class ObmpCmLingueModel extends Model
{
    protected $table = 'obmp_cm_lingue';
    protected $primaryKey = 'obmp_cm_lingue_id';
    protected $returnType = ObmpCmLingueEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'obmp_cm_rooms_id',
  1 => 'hotel_id',
  2 => 'obmp_cm_lingue_codice',
  3 => 'obmp_cm_lingue_nome',
  4 => 'obmp_cm_lingue_descrizione',
  5 => 'obmp_cm_lingue_html1',
  6 => 'obmp_cm_lingue_html2',
  7 => 'obmp_cm_lingue_html3',
  8 => 'obmp_cm_lingue_note',
  9 => 'obmp_cm_lingue_politiche',
  10 => 'obmp_cm_lingue_condizioni',
  11 => 'obmp_cm_lingue_data_record',
  12 => 'obmp_cm_lingue_utente_id',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
  'obmp_cm_lingue_id' => 
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
  'obmp_cm_rooms_id' => 
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
  0 => 'obmp_cm_lingue_id',
  1 => 'obmp_cm_rooms_id',
);
    private const EXPORT_FIELDS = array (
  0 => 'obmp_cm_lingue_id',
  1 => 'obmp_cm_rooms_id',
  2 => 'hotel_id',
  3 => 'obmp_cm_lingue_codice',
  4 => 'obmp_cm_lingue_nome',
  5 => 'obmp_cm_lingue_descrizione',
  6 => 'obmp_cm_lingue_html1',
  7 => 'obmp_cm_lingue_html2',
  8 => 'obmp_cm_lingue_html3',
  9 => 'obmp_cm_lingue_note',
  10 => 'obmp_cm_lingue_politiche',
  11 => 'obmp_cm_lingue_condizioni',
  12 => 'obmp_cm_lingue_utente_id',
);
    private const RELATION_SEARCHES = array (
  'obmp_cm_rooms_id' => 
  array (
    'table' => 'obmp_cm_rooms',
    'key' => 'obmp_cm_rooms_id',
    'label' => 'obmp_cm_rooms_room_note',
    'mode' => 'select',
  ),
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('obmp_cm_lingue');
        $builder->select([
            'obmp_cm_lingue.obmp_cm_lingue_id AS obmp_cm_lingue_id',
            'obmp_cm_lingue.obmp_cm_rooms_id AS obmp_cm_rooms_id',
            'obmp_cm_lingue.hotel_id AS hotel_id',
            'obmp_cm_lingue.obmp_cm_lingue_codice AS obmp_cm_lingue_codice',
            'obmp_cm_lingue.obmp_cm_lingue_nome AS obmp_cm_lingue_nome',
            'obmp_cm_lingue.obmp_cm_lingue_descrizione AS obmp_cm_lingue_descrizione',
            'obmp_cm_lingue.obmp_cm_lingue_html1 AS obmp_cm_lingue_html1',
            'obmp_cm_lingue.obmp_cm_lingue_html2 AS obmp_cm_lingue_html2',
            'obmp_cm_lingue.obmp_cm_lingue_html3 AS obmp_cm_lingue_html3',
            'obmp_cm_lingue.obmp_cm_lingue_note AS obmp_cm_lingue_note',
            'obmp_cm_lingue.obmp_cm_lingue_politiche AS obmp_cm_lingue_politiche',
            'obmp_cm_lingue.obmp_cm_lingue_condizioni AS obmp_cm_lingue_condizioni',
            'obmp_cm_lingue.obmp_cm_lingue_data_record AS obmp_cm_lingue_data_record',
            'obmp_cm_lingue.obmp_cm_lingue_utente_id AS obmp_cm_lingue_utente_id',
            'obmp_cm_rooms__obmp_cm_rooms_id.obmp_cm_rooms_room_note AS obmp_cm_rooms_obmp_cm_rooms_room_note'
        ]);
        $builder->join('obmp_cm_rooms AS obmp_cm_rooms__obmp_cm_rooms_id', 'obmp_cm_rooms__obmp_cm_rooms_id.obmp_cm_rooms_id = obmp_cm_lingue.obmp_cm_rooms_id', 'left');
        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('obmp_cm_lingue');
        $builder->select([
            'obmp_cm_lingue.obmp_cm_lingue_id AS obmp_cm_lingue_id',
            'obmp_cm_lingue.obmp_cm_rooms_id AS obmp_cm_rooms_id',
            'obmp_cm_lingue.hotel_id AS hotel_id',
            'obmp_cm_lingue.obmp_cm_lingue_codice AS obmp_cm_lingue_codice',
            'obmp_cm_lingue.obmp_cm_lingue_nome AS obmp_cm_lingue_nome',
            'obmp_cm_lingue.obmp_cm_lingue_descrizione AS obmp_cm_lingue_descrizione',
            'obmp_cm_lingue.obmp_cm_lingue_note AS obmp_cm_lingue_note',
            'obmp_cm_lingue.obmp_cm_lingue_politiche AS obmp_cm_lingue_politiche',
            'obmp_cm_lingue.obmp_cm_lingue_condizioni AS obmp_cm_lingue_condizioni',
            'obmp_cm_lingue.obmp_cm_lingue_utente_id AS obmp_cm_lingue_utente_id',
            'obmp_cm_rooms__obmp_cm_rooms_id.obmp_cm_rooms_room_note AS obmp_cm_rooms_obmp_cm_rooms_room_note'
        ]);
        $builder->join('obmp_cm_rooms AS obmp_cm_rooms__obmp_cm_rooms_id', 'obmp_cm_rooms__obmp_cm_rooms_id.obmp_cm_rooms_id = obmp_cm_lingue.obmp_cm_rooms_id', 'left');
        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('obmp_cm_lingue');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('obmp_cm_lingue.obmp_cm_lingue_id', $id)
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
        string $sort = 'obmp_cm_lingue_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'obmp_cm_lingue_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('obmp_cm_lingue.' . $sort, $direction)
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
        $builder = $this->db->table('obmp_cm_lingue');
        $builder->select([
            'obmp_cm_lingue.obmp_cm_lingue_id AS obmp_cm_lingue_id',
            'obmp_cm_lingue.obmp_cm_rooms_id AS obmp_cm_rooms_id',
            'obmp_cm_lingue.hotel_id AS hotel_id',
            'obmp_cm_lingue.obmp_cm_lingue_codice AS obmp_cm_lingue_codice',
            'obmp_cm_lingue.obmp_cm_lingue_nome AS obmp_cm_lingue_nome',
            'obmp_cm_lingue.obmp_cm_lingue_descrizione AS obmp_cm_lingue_descrizione',
            'obmp_cm_lingue.obmp_cm_lingue_html1 AS obmp_cm_lingue_html1',
            'obmp_cm_lingue.obmp_cm_lingue_html2 AS obmp_cm_lingue_html2',
            'obmp_cm_lingue.obmp_cm_lingue_html3 AS obmp_cm_lingue_html3',
            'obmp_cm_lingue.obmp_cm_lingue_note AS obmp_cm_lingue_note',
            'obmp_cm_lingue.obmp_cm_lingue_politiche AS obmp_cm_lingue_politiche',
            'obmp_cm_lingue.obmp_cm_lingue_condizioni AS obmp_cm_lingue_condizioni',
            'obmp_cm_lingue.obmp_cm_lingue_utente_id AS obmp_cm_lingue_utente_id',
            'obmp_cm_rooms__obmp_cm_rooms_id.obmp_cm_rooms_room_note AS obmp_cm_rooms_obmp_cm_rooms_room_note'
        ]);
        $builder->join('obmp_cm_rooms AS obmp_cm_rooms__obmp_cm_rooms_id', 'obmp_cm_rooms__obmp_cm_rooms_id.obmp_cm_rooms_id = obmp_cm_lingue.obmp_cm_rooms_id', 'left');
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('obmp_cm_lingue.obmp_cm_lingue_id >', $after);
        }

        return $builder
            ->orderBy('obmp_cm_lingue.obmp_cm_lingue_id', 'ASC')
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

            $column = $qualified ? 'obmp_cm_lingue.' . $field : $field;
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
                $builder->where('obmp_cm_lingue.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'obmp_cm_lingue_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'obmp_cm_lingue_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('obmp_cm_lingue.' . $sort, $direction)
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
    /** Restituisce le opzioni della relazione obmp_cm_rooms_id. */
    public function getObmpCmRoomsObmpCmRoomsIdOptions(): array
    {
        return $this->db->table('obmp_cm_rooms')
            ->select(['obmp_cm_rooms_id', 'obmp_cm_rooms_room_note'])
            ->orderBy('obmp_cm_rooms_room_note', 'ASC')
            ->get()
            ->getResult();
    }
    public function relationOptions(): array
    {
        return [
            'obmp_cm_rooms_id' => $this->toOptions($this->getObmpCmRoomsObmpCmRoomsIdOptions(), 'obmp_cm_rooms_id', 'obmp_cm_rooms_room_note'),
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
