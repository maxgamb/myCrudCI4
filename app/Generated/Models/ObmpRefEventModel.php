<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\ObmpRefEventEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per obmp_ref_event; tutte le query del CRUD sono centralizzate qui. */
final class ObmpRefEventModel extends Model
{
    protected $table = 'obmp_ref_event';
    protected $primaryKey = 'ref_event_id';
    protected $returnType = ObmpRefEventEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'ref_site_id',
  1 => 'hotel_id',
  2 => 'listino_nome_id',
  3 => 'agenzia_id',
  4 => 'ref_event_nome',
  5 => 'event_dal',
  6 => 'event_al',
  7 => 'ref_event_note',
  8 => 'ref_event_data_record',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
  'ref_event_id' => 
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
  'ref_site_id' => 
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
);
    private const SORTABLE_FIELDS = array (
  0 => 'ref_event_id',
  1 => 'ref_site_id',
  2 => 'hotel_id',
  3 => 'listino_nome_id',
  4 => 'agenzia_id',
);
    private const EXPORT_FIELDS = array (
  0 => 'ref_event_id',
  1 => 'ref_site_id',
  2 => 'hotel_id',
  3 => 'listino_nome_id',
  4 => 'agenzia_id',
  5 => 'ref_event_nome',
  6 => 'event_dal',
  7 => 'event_al',
  8 => 'ref_event_note',
);
    private const RELATION_SEARCHES = array (
  'agenzia_id' => 
  array (
    'table' => 'agenzie',
    'key' => 'agenzia_id',
    'label' => 'agenzia_tipologia',
    'mode' => 'select',
  ),
  'listino_nome_id' => 
  array (
    'table' => 'listino_nome_obmp',
    'key' => 'listino_nome_id',
    'label' => 'listino_nome',
    'mode' => 'select',
  ),
  'ref_site_id' => 
  array (
    'table' => 'obmp_ref_site',
    'key' => 'ref_site_id',
    'label' => 'ref_site_nome',
    'mode' => 'select',
  ),
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('obmp_ref_event');
        $builder->select([
            'obmp_ref_event.ref_event_id AS ref_event_id',
            'obmp_ref_event.ref_site_id AS ref_site_id',
            'obmp_ref_event.hotel_id AS hotel_id',
            'obmp_ref_event.listino_nome_id AS listino_nome_id',
            'obmp_ref_event.agenzia_id AS agenzia_id',
            'obmp_ref_event.ref_event_nome AS ref_event_nome',
            'obmp_ref_event.event_dal AS event_dal',
            'obmp_ref_event.event_al AS event_al',
            'obmp_ref_event.ref_event_note AS ref_event_note',
            'obmp_ref_event.ref_event_data_record AS ref_event_data_record',
            'agenzie__agenzia_id.agenzia_tipologia AS agenzie_agenzia_tipologia',
            'listino_nome_obmp__listino_nome_id.listino_nome AS listino_nome_obmp_listino_nome',
            'obmp_ref_site__ref_site_id.ref_site_nome AS obmp_ref_site_ref_site_nome'
        ]);
        $builder->join('agenzie AS agenzie__agenzia_id', 'agenzie__agenzia_id.agenzia_id = obmp_ref_event.agenzia_id', 'left');
        $builder->join('listino_nome_obmp AS listino_nome_obmp__listino_nome_id', 'listino_nome_obmp__listino_nome_id.listino_nome_id = obmp_ref_event.listino_nome_id', 'left');
        $builder->join('obmp_ref_site AS obmp_ref_site__ref_site_id', 'obmp_ref_site__ref_site_id.ref_site_id = obmp_ref_event.ref_site_id', 'left');
        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('obmp_ref_event');
        $builder->select([
            'obmp_ref_event.ref_event_id AS ref_event_id',
            'obmp_ref_event.ref_site_id AS ref_site_id',
            'obmp_ref_event.hotel_id AS hotel_id',
            'obmp_ref_event.listino_nome_id AS listino_nome_id',
            'obmp_ref_event.agenzia_id AS agenzia_id',
            'obmp_ref_event.ref_event_nome AS ref_event_nome',
            'obmp_ref_event.event_dal AS event_dal',
            'obmp_ref_event.event_al AS event_al',
            'obmp_ref_event.ref_event_note AS ref_event_note',
            'agenzie__agenzia_id.agenzia_tipologia AS agenzie_agenzia_tipologia',
            'listino_nome_obmp__listino_nome_id.listino_nome AS listino_nome_obmp_listino_nome',
            'obmp_ref_site__ref_site_id.ref_site_nome AS obmp_ref_site_ref_site_nome'
        ]);
        $builder->join('agenzie AS agenzie__agenzia_id', 'agenzie__agenzia_id.agenzia_id = obmp_ref_event.agenzia_id', 'left');
        $builder->join('listino_nome_obmp AS listino_nome_obmp__listino_nome_id', 'listino_nome_obmp__listino_nome_id.listino_nome_id = obmp_ref_event.listino_nome_id', 'left');
        $builder->join('obmp_ref_site AS obmp_ref_site__ref_site_id', 'obmp_ref_site__ref_site_id.ref_site_id = obmp_ref_event.ref_site_id', 'left');
        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('obmp_ref_event');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('obmp_ref_event.ref_event_id', $id)
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
        string $sort = 'ref_event_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'ref_event_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('obmp_ref_event.' . $sort, $direction)
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
        $builder = $this->db->table('obmp_ref_event');
        $builder->select([
            'obmp_ref_event.ref_event_id AS ref_event_id',
            'obmp_ref_event.ref_site_id AS ref_site_id',
            'obmp_ref_event.hotel_id AS hotel_id',
            'obmp_ref_event.listino_nome_id AS listino_nome_id',
            'obmp_ref_event.agenzia_id AS agenzia_id',
            'obmp_ref_event.ref_event_nome AS ref_event_nome',
            'obmp_ref_event.event_dal AS event_dal',
            'obmp_ref_event.event_al AS event_al',
            'obmp_ref_event.ref_event_note AS ref_event_note',
            'agenzie__agenzia_id.agenzia_tipologia AS agenzie_agenzia_tipologia',
            'listino_nome_obmp__listino_nome_id.listino_nome AS listino_nome_obmp_listino_nome',
            'obmp_ref_site__ref_site_id.ref_site_nome AS obmp_ref_site_ref_site_nome'
        ]);
        $builder->join('agenzie AS agenzie__agenzia_id', 'agenzie__agenzia_id.agenzia_id = obmp_ref_event.agenzia_id', 'left');
        $builder->join('listino_nome_obmp AS listino_nome_obmp__listino_nome_id', 'listino_nome_obmp__listino_nome_id.listino_nome_id = obmp_ref_event.listino_nome_id', 'left');
        $builder->join('obmp_ref_site AS obmp_ref_site__ref_site_id', 'obmp_ref_site__ref_site_id.ref_site_id = obmp_ref_event.ref_site_id', 'left');
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('obmp_ref_event.ref_event_id >', $after);
        }

        return $builder
            ->orderBy('obmp_ref_event.ref_event_id', 'ASC')
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

            $column = $qualified ? 'obmp_ref_event.' . $field : $field;
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
                $builder->where('obmp_ref_event.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'ref_event_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'ref_event_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('obmp_ref_event.' . $sort, $direction)
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
            ->select(['agenzia_id', 'agenzia_tipologia'])
            ->orderBy('agenzia_tipologia', 'ASC')
            ->get()
            ->getResult();
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
    /** Restituisce le opzioni della relazione ref_site_id. */
    public function getObmpRefSiteRefSiteIdOptions(): array
    {
        return $this->db->table('obmp_ref_site')
            ->select(['ref_site_id', 'ref_site_nome'])
            ->orderBy('ref_site_nome', 'ASC')
            ->get()
            ->getResult();
    }
    public function relationOptions(): array
    {
        return [
            'agenzia_id' => $this->toOptions($this->getAgenzieAgenziaIdOptions(), 'agenzia_id', 'agenzia_tipologia'),
            'listino_nome_id' => $this->toOptions($this->getListinoNomeObmpListinoNomeIdOptions(), 'listino_nome_id', 'listino_nome'),
            'ref_site_id' => $this->toOptions($this->getObmpRefSiteRefSiteIdOptions(), 'ref_site_id', 'ref_site_nome'),
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
