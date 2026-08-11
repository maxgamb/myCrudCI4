<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\StoreEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;
use RuntimeException;
use Throwable;

/** Model per store; tutte le query del CRUD sono centralizzate qui. */
final class StoreModel extends Model
{
    protected $table = 'store';
    protected $primaryKey = 'store_id';
    protected $returnType = StoreEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'manager_staff_id',
  1 => 'address_id',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
  'store_id' => 
  array (
    'type' => 'tinyint',
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
  'manager_staff_id' => 
  array (
    'type' => 'tinyint',
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
  'address_id' => 
  array (
    'type' => 'smallint',
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
  0 => 'store_id',
  1 => 'manager_staff_id',
  2 => 'address_id',
);
    private const EXPORT_FIELDS = array (
  0 => 'store_id',
  1 => 'manager_staff_id',
  2 => 'address_id',
  3 => 'last_update',
);
    private const PRIMARY_KEYS = array (
  0 => 'store_id',
);
    private const RELATION_SEARCHES = array (
  'address_id' => 
  array (
    'table' => 'address',
    'key' => 'address_id',
    'displayField' => 'address',
    'displayTemplate' => '',
    'displayFields' => 
    array (
      0 => 'address',
    ),
    'mode' => 'select',
  ),
  'manager_staff_id' => 
  array (
    'table' => 'staff',
    'key' => 'staff_id',
    'displayField' => 'last_name',
    'displayTemplate' => '',
    'displayFields' => 
    array (
      0 => 'last_name',
    ),
    'mode' => 'select',
  ),
);
    private const RELATED_CREATES = array (
  'manager_staff_id' => 
  array (
    'table' => 'staff',
    'key' => 'staff_id',
    'keyAutoIncrement' => true,
    'fields' => 
    array (
      0 => 'first_name',
      1 => 'last_name',
      2 => 'address_id',
      3 => 'email',
      4 => 'store_id',
      5 => 'active',
      6 => 'username',
      7 => 'password',
    ),
    'nullableFields' => 
    array (
      0 => 'email',
      1 => 'password',
    ),
    'defaultedFields' => 
    array (
      0 => 'active',
    ),
    'dateTimeFields' => 
    array (
    ),
  ),
);
    private const RELATED_CREATE_RELATIONS = array (
  'manager_staff_id' => 
  array (
    'address_id' => 
    array (
      'table' => 'address',
      'key' => 'address_id',
      'displayField' => 'address',
      'mode' => 'select',
    ),
    'store_id' => 
    array (
      'table' => 'store',
      'key' => 'store_id',
      'displayField' => 'store_id',
      'mode' => 'select',
    ),
  ),
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('store');
        $builder->select([
            'store.store_id AS store_id',
            'store.manager_staff_id AS manager_staff_id',
            'store.address_id AS address_id',
            'store.last_update AS last_update',
            'address__address_id.address AS address_id__label',
            'staff__manager_staff_id.last_name AS manager_staff_id__label'
        ]);
        $this->joinAddressAddressId($builder);
        $this->joinStaffManagerStaffId($builder);
        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('store');
        $builder->select([
            'store.store_id AS store_id',
            'store.manager_staff_id AS manager_staff_id',
            'store.address_id AS address_id',
            'store.last_update AS last_update',
            'address__address_id.address AS address_id__label',
            'staff__manager_staff_id.last_name AS manager_staff_id__label'
        ]);
        $this->joinAddressAddressId($builder);
        $this->joinStaffManagerStaffId($builder);
        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('store');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('store.store_id', $id)
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
        string $sort = 'store_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'store_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('store.' . $sort, $direction)
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
        $builder = $this->db->table('store');
        $builder->select([
            'store.store_id AS store_id',
            'store.manager_staff_id AS manager_staff_id',
            'store.address_id AS address_id',
            'store.last_update AS last_update',
            'address__address_id.address AS address_id__label',
            'staff__manager_staff_id.last_name AS manager_staff_id__label'
        ]);
        $this->joinAddressAddressId($builder);
        $this->joinStaffManagerStaffId($builder);
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('store.store_id >', $after);
        }

        return $builder
            ->orderBy('store.store_id', 'ASC')
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

            $column = $qualified ? 'store.' . $field : $field;
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

    /**
     * Inserisce il record corrente e, se richiesto dal form, crea prima i
     * record padre nella stessa transazione usando la PK generata come FK.
     */
    public function createRecord(array $data, array $related = []): int|string
    {
        $transactional = $related !== [];
        if ($transactional) {
            $this->db->transBegin();
        }

        try {
            foreach ($related as $field => $payload) {
                if (!is_array($payload) || !isset(self::RELATED_CREATES[$field])) {
                    continue;
                }
                $data[$field] = $this->createRelatedRecord((string) $field, $payload);
            }

            $id = $this->insert($data, true);
            if ($id === false) {
                throw new RuntimeException(implode(' ', $this->errors()) ?: 'Inserimento non riuscito.');
            }

            if ($transactional) {
                if (!$this->db->transStatus()) {
                    throw new RuntimeException('Transazione di inserimento non riuscita.');
                }
                $this->db->transCommit();
            }
        } catch (Throwable $e) {
            if ($transactional) {
                $this->db->transRollback();
            }
            throw $e;
        }

        $this->clearListCountCache();
        return is_int($id) ? $id : (string) $id;
    }

    /** Crea un singolo record padre autorizzato dalla configurazione generata. */
    private function createRelatedRecord(string $field, array $data): int|string
    {
        $definition = self::RELATED_CREATES[$field] ?? null;
        if (!is_array($definition)) {
            throw new RuntimeException('Creazione record collegato non autorizzata per ' . $field . '.');
        }

        $allowed = array_fill_keys((array) ($definition['fields'] ?? []), true);
        $payload = array_intersect_key($data, $allowed);

        // I form HTML inviano stringa vuota anche per campi opzionali. Per i
        // nullable usiamo NULL; per colonne con DEFAULT omettiamo il valore e
        // lasciamo che sia il database ad applicare la propria policy.
        $nullable = array_fill_keys((array) ($definition['nullableFields'] ?? []), true);
        $defaulted = array_fill_keys((array) ($definition['defaultedFields'] ?? []), true);
        foreach ($payload as $payloadField => $payloadValue) {
            if (!is_string($payloadValue) || trim($payloadValue) !== '') {
                continue;
            }
            if (isset($defaulted[$payloadField])) {
                unset($payload[$payloadField]);
                continue;
            }
            if (isset($nullable[$payloadField])) {
                $payload[$payloadField] = null;
            }
        }

        // datetime-local usa il separatore T; normalizziamo al formato SQL
        // prima dell'insert generico del record collegato.
        foreach ((array) ($definition['dateTimeFields'] ?? []) as $dateTimeField) {
            if (isset($payload[$dateTimeField]) && is_string($payload[$dateTimeField])) {
                $payload[$dateTimeField] = str_replace('T', ' ', $payload[$dateTimeField]);
            }
        }

        $table = (string) ($definition['table'] ?? '');
        $key = (string) ($definition['key'] ?? '');
        if ($table === '' || $key === '') {
            throw new RuntimeException('Configurazione record collegato incompleta.');
        }

        if (!$this->db->table($table)->insert($payload)) {
            throw new RuntimeException('Inserimento record collegato non riuscito: ' . $table . '.');
        }

        if (!empty($definition['keyAutoIncrement'])) {
            $id = $this->db->insertID();
            if ($id === 0 || $id === '0' || $id === '') {
                throw new RuntimeException('Chiave generata non disponibile per ' . $table . '.');
            }
            return is_int($id) ? $id : (string) $id;
        }

        $id = $payload[$key] ?? null;
        if (!is_int($id) && !is_string($id)) {
            throw new RuntimeException('La chiave del record collegato deve essere valorizzata: ' . $key . '.');
        }

        return $id;
    }
    /** FK store.address_id -> address.address_id; risultato: address_id__label. */
    private function joinAddressAddressId(BaseBuilder $builder): BaseBuilder
    {
        $builder->join(
            'address AS address__address_id',
            'address__address_id.address_id = store.address_id',
            'left'
        );

        return $builder;
    }
    /** FK store.manager_staff_id -> staff.staff_id; risultato: manager_staff_id__label. */
    private function joinStaffManagerStaffId(BaseBuilder $builder): BaseBuilder
    {
        $builder->join(
            'staff AS staff__manager_staff_id',
            'staff__manager_staff_id.staff_id = store.manager_staff_id',
            'left'
        );

        return $builder;
    }
    /** Elenco REST paginato con whitelist di filtri e ordinamento. */
    public function apiList(array $query, array $filterable, array $sortable): array
    {
        $page = max(1, (int) ($query['page'] ?? 1));
        $perPage = max(1, min(100, (int) ($query['perPage'] ?? 25)));
        $builder = $this->baseBuilder();

        foreach ((array) ($query['filter'] ?? []) as $field => $value) {
            if (is_scalar($value) && in_array($field, $filterable, true) && (string) $value !== '') {
                $builder->where('store.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'store_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'store_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('store.' . $sort, $direction)
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
    /** Restituisce le opzioni della relazione address_id. */
    public function getAddressAddressIdOptions(): array
    {
        return $this->db->table('address')
            ->select(array (
  0 => 'address_id',
  1 => 'address',
))
            ->orderBy('address', 'ASC')
            ->get()
            ->getResultArray();
    }
    /** Restituisce le opzioni della relazione manager_staff_id. */
    public function getStaffManagerStaffIdOptions(): array
    {
        return $this->db->table('staff')
            ->select(array (
  0 => 'staff_id',
  1 => 'last_name',
))
            ->orderBy('last_name', 'ASC')
            ->get()
            ->getResultArray();
    }
    /**
     * Opzioni delle FK appartenenti ai parent creati inline.
     * La whitelist deriva esclusivamente dalle FK reali dello schema.
     */
    public function relatedCreateRelationOptions(): array
    {
        $result = [];
        foreach (self::RELATED_CREATE_RELATIONS as $relationField => $fields) {
            foreach ((array) $fields as $field => $definition) {
                if (($definition['mode'] ?? 'select') !== 'select') {
                    continue;
                }
                $table = (string) $definition['table'];
                $key = (string) $definition['key'];
                $display = (string) $definition['displayField'];
                $rows = $this->db->table($table)
                    ->select([$key, $display])
                    ->orderBy($display, 'ASC')
                    ->get()
                    ->getResultArray();
                foreach ($rows as $row) {
                    $result[(string) $relationField][(string) $field][] = [
                        'id' => (string) ($row[$key] ?? ''),
                        'text' => (string) ($row[$display] ?? $row[$key] ?? ''),
                    ];
                }
            }
        }
        return $result;
    }

    public function relationOptions(): array
    {
        return [
            'address_id' => $this->toRelationOptions($this->getAddressAddressIdOptions(), 'address_id'),
            'manager_staff_id' => $this->toRelationOptions($this->getStaffManagerStaffIdOptions(), 'manager_staff_id'),
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

    /**
     * HasMany scaffolding: query dedicata alla relazione figlia.
     * Carica al massimo una riga in più per determinare se esistono altri risultati.
     * Punto di estensione: aggiungere qui eventuali JOIN/ordinamenti applicativi.
     */
    public function getCustomerByStoreId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('customer')
            ->select(array (
  0 => 'customer.customer_id AS customer_id',
  1 => 'customer.store_id AS store_id',
  2 => 'customer.first_name AS first_name',
  3 => 'customer.last_name AS last_name',
  4 => 'customer.email AS email',
  5 => 'customer.address_id AS address_id',
  6 => 'customer.active AS active',
  7 => 'customer.create_date AS create_date',
  8 => 'customer.last_update AS last_update',
))
            ->where('store_id', $parentId)
            ->orderBy('customer_id', 'DESC')
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
    /**
     * HasMany scaffolding: query dedicata alla relazione figlia.
     * Carica al massimo una riga in più per determinare se esistono altri risultati.
     * Punto di estensione: aggiungere qui eventuali JOIN/ordinamenti applicativi.
     */
    public function getInventoryByStoreId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('inventory')
            ->select(array (
  0 => 'inventory.inventory_id AS inventory_id',
  1 => 'inventory.film_id AS film_id',
  2 => 'inventory.store_id AS store_id',
  3 => 'inventory.last_update AS last_update',
))
            ->where('store_id', $parentId)
            ->orderBy('inventory_id', 'DESC')
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
    /**
     * HasMany scaffolding: query dedicata alla relazione figlia.
     * Carica al massimo una riga in più per determinare se esistono altri risultati.
     * Punto di estensione: aggiungere qui eventuali JOIN/ordinamenti applicativi.
     */
    public function getStaffByStoreId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('staff')
            ->select(array (
  0 => 'staff.staff_id AS staff_id',
  1 => 'staff.first_name AS first_name',
  2 => 'staff.last_name AS last_name',
  3 => 'staff.address_id AS address_id',
  4 => 'staff.picture AS picture',
  5 => 'staff.email AS email',
  6 => 'staff.store_id AS store_id',
  7 => 'staff.active AS active',
  8 => 'staff.username AS username',
  9 => 'staff.password AS password',
  10 => 'staff.last_update AS last_update',
))
            ->where('store_id', $parentId)
            ->orderBy('staff_id', 'DESC')
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
        $result['customer__store_id'] = $this->getCustomerByStoreId($parentId, 20);

        $result['inventory__store_id'] = $this->getInventoryByStoreId($parentId, 20);

        $result['staff__store_id'] = $this->getStaffByStoreId($parentId, 20);
        return $result;
    }

}
