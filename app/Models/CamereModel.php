<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\CamereEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per camere; tutte le query del CRUD sono centralizzate qui. */
final class CamereModel extends Model
{
    protected $table = 'camere';
    protected $primaryKey = 'camera_id';
    protected $returnType = CamereEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'camera_id',
  1 => 'hotel_id',
  2 => 'numero_camera',
  3 => 'tipologia_camera',
  4 => 'tipologia_id',
  5 => 'camere_max_pax',
  6 => 'camere_metri_quadri',
  7 => 'camere_vista',
  8 => 'camere_piano',
  9 => 'camere_bagno',
  10 => 'camere_edificio',
  11 => 'review_tot',
  12 => 'camere_data_record',
  13 => 'camere_utente_id',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
  'camera_id' => 
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
  'numero_camera' => 
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
  0 => 'camera_id',
  1 => 'hotel_id',
  2 => 'numero_camera',
  3 => 'tipologia_id',
);
    private const EXPORT_FIELDS = array (
  0 => 'camera_id',
  1 => 'hotel_id',
  2 => 'numero_camera',
  3 => 'tipologia_camera',
  4 => 'tipologia_id',
  5 => 'camere_max_pax',
  6 => 'camere_metri_quadri',
  7 => 'camere_vista',
  8 => 'camere_piano',
  9 => 'camere_bagno',
  10 => 'camere_edificio',
  11 => 'review_tot',
  12 => 'camere_utente_id',
);
    private const RELATION_SEARCHES = array (
  'tipologia_id' => 
  array (
    'table' => 'tipologia_camera',
    'key' => 'tipologia_id',
    'label' => 'nome_tipologia',
    'mode' => 'select',
  ),
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('camere');
        $builder->select([
            'camere.camera_id AS camera_id',
            'camere.hotel_id AS hotel_id',
            'camere.numero_camera AS numero_camera',
            'camere.tipologia_camera AS tipologia_camera',
            'camere.tipologia_id AS tipologia_id',
            'camere.camere_max_pax AS camere_max_pax',
            'camere.camere_metri_quadri AS camere_metri_quadri',
            'camere.camere_vista AS camere_vista',
            'camere.camere_piano AS camere_piano',
            'camere.camere_bagno AS camere_bagno',
            'camere.camere_edificio AS camere_edificio',
            'camere.review_tot AS review_tot',
            'camere.camere_data_record AS camere_data_record',
            'camere.camere_utente_id AS camere_utente_id',
            'tipologia_camera__tipologia_id.nome_tipologia AS tipologia_camera_nome_tipologia'
        ]);
        $builder->join('tipologia_camera AS tipologia_camera__tipologia_id', 'tipologia_camera__tipologia_id.tipologia_id = camere.tipologia_id', 'left');
        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('camere');
        $builder->select([
            'camere.camera_id AS camera_id',
            'camere.hotel_id AS hotel_id',
            'camere.numero_camera AS numero_camera',
            'camere.tipologia_camera AS tipologia_camera',
            'camere.tipologia_id AS tipologia_id',
            'camere.camere_max_pax AS camere_max_pax',
            'camere.camere_metri_quadri AS camere_metri_quadri',
            'camere.camere_vista AS camere_vista',
            'camere.camere_piano AS camere_piano',
            'camere.camere_bagno AS camere_bagno',
            'tipologia_camera__tipologia_id.nome_tipologia AS tipologia_camera_nome_tipologia'
        ]);
        $builder->join('tipologia_camera AS tipologia_camera__tipologia_id', 'tipologia_camera__tipologia_id.tipologia_id = camere.tipologia_id', 'left');
        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('camere');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('camere.camera_id', $id)
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
        string $sort = 'camera_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'camera_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('camere.' . $sort, $direction)
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
        $builder = $this->db->table('camere');
        $builder->select([
            'camere.camera_id AS camera_id',
            'camere.hotel_id AS hotel_id',
            'camere.numero_camera AS numero_camera',
            'camere.tipologia_camera AS tipologia_camera',
            'camere.tipologia_id AS tipologia_id',
            'camere.camere_max_pax AS camere_max_pax',
            'camere.camere_metri_quadri AS camere_metri_quadri',
            'camere.camere_vista AS camere_vista',
            'camere.camere_piano AS camere_piano',
            'camere.camere_bagno AS camere_bagno',
            'camere.camere_edificio AS camere_edificio',
            'camere.review_tot AS review_tot',
            'camere.camere_utente_id AS camere_utente_id',
            'tipologia_camera__tipologia_id.nome_tipologia AS tipologia_camera_nome_tipologia'
        ]);
        $builder->join('tipologia_camera AS tipologia_camera__tipologia_id', 'tipologia_camera__tipologia_id.tipologia_id = camere.tipologia_id', 'left');
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('camere.camera_id >', $after);
        }

        return $builder
            ->orderBy('camere.camera_id', 'ASC')
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

            $column = $qualified ? 'camere.' . $field : $field;
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
                $builder->where('camere.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'camera_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'camera_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('camere.' . $sort, $direction)
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
    /** Restituisce le opzioni della relazione tipologia_id. */
    public function getTipologiaCameraTipologiaIdOptions(): array
    {
        return $this->db->table('tipologia_camera')
            ->select(['tipologia_id', 'nome_tipologia'])
            ->orderBy('nome_tipologia', 'ASC')
            ->get()
            ->getResult();
    }
    public function relationOptions(): array
    {
        return [
            'tipologia_id' => $this->toOptions($this->getTipologiaCameraTipologiaIdOptions(), 'tipologia_id', 'nome_tipologia'),
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
    public function getContiByCameraId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('conti')
            ->where('camera_id', $parentId)
            ->orderBy('conto_id', 'DESC')
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
    /** Carica al massimo una riga in più per determinare se esistono altri risultati. */
    public function getFoglioGiornoByCameraId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('foglio_giorno')
            ->where('camera_id', $parentId)
            ->orderBy('foglio_id', 'DESC')
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
    /** Carica al massimo una riga in più per determinare se esistono altri risultati. */
    public function getGuastiByCameraId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('guasti')
            ->where('camera_id', $parentId)
            ->orderBy('guasto_id', 'DESC')
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
        $result['conti__camera_id'] = $this->getContiByCameraId($parentId, 20);

        $result['foglio_giorno__camera_id'] = $this->getFoglioGiornoByCameraId($parentId, 20);

        $result['guasti__camera_id'] = $this->getGuastiByCameraId($parentId, 20);
        return $result;
    }

}
